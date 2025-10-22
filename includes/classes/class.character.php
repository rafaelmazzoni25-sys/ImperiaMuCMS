<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Character
{
    private $_3rdSkillTreeSkills = ["300", "301", "302", "303", "304", "305", "306", "307", "308", "309", "310", "311", "312", "313", "314", "315", "316", "317", "318", "319", "320", "321", "322", "323", "324", "325", "326", "327", "328", "329", "330", "331", "332", "333", "334", "335", "336", "337", "338", "339", "340", "341", "342", "343", "344", "345", "346", "347", "348", "349", "350", "351", "352", "353", "354", "355", "356", "357", "358", "359", "360", "361", "362", "363", "364", "366", "367", "368", "369", "370", "371", "372", "373", "374", "375", "377", "378", "379", "380", "381", "382", "383", "384", "385", "386", "387", "388", "389", "390", "391", "392", "393", "394", "395", "397", "398", "399", "400", "401", "402", "403", "404", "405", "406", "407", "409", "410", "411", "412", "413", "414", "415", "416", "417", "418", "419", "420", "421", "422", "423", "424", "425", "426", "427", "428", "429", "430", "431", "432", "433", "434", "435", "436", "437", "438", "439", "440", "441", "442", "443", "445", "446", "447", "448", "449", "450", "451", "452", "453", "454", "455", "456", "457", "458", "459", "460", "461", "462", "463", "465", "466", "467", "468", "469", "470", "471", "472", "473", "475", "476", "478", "479", "480", "481", "482", "483", "484", "485", "486", "487", "488", "489", "490", "491", "492", "493", "494", "495", "496", "497", "504", "505", "506", "507", "508", "509", "510", "511", "512", "513", "514", "515", "516", "517", "518", "519", "520", "521", "522", "523", "524", "526", "527", "528", "529", "530", "531", "532", "533", "534", "535", "536", "538", "539", "548", "549", "550", "551", "552", "554", "555", "556", "557", "558", "559", "560", "561", "562", "563", "564", "565", "566", "567", "568", "569", "571", "572", "573", "574", "578", "579", "580", "581", "582", "583", "584", "585", "586", "587", "588", "589", "590", "591", "592", "593", "594", "595", "596", "597", "598", "599", "600", "601", "602", "603", "604", "605", "606", "607", "608", "609", "610", "611", "612", "613", "614", "615", "616", "617", "623", "624", "625", "626", "627", "628", "629", "630", "631", "634", "635", "636", "637", "638", "639", "640", "641", "642", "643", "644", "645", "646", "647", "648", "649", "650", "651", "652", "653", "654", "655", "656", "657", "658", "659", "660", "663", "664", "665", "666", "667", "668", "669", "670", "671", "672", "673", "674", "675", "676", "677", "678", "679", "680", "681", "682", "683", "684", "685", "686", "687", "688", "689", "690", "691", "692", "693", "694", "695", "696", "697", "698", "699", "700", "701", "702", "703", "704", "705", "706", "707", "708", "709", "710", "711", "712", "713", "714", "715", "716", "717", "718", "719", "743", "744", "745", "746", "747", "748", "749", "750", "751", "752", "753", "754", "755", "756", "758", "759", "760", "761", "762", "763", "765", "766", "768", "769", "770", "771", "772", "773", "774", "775", "776", "777", "778", "779", "780", "781", "782", "783", "784", "785", "786", "787", "788", "789", "790", "791", "792", "793", "794"];
    public function is3rdSkillTreeSkill($skillIndex)
    {
        if (in_array($skillIndex, $this->_3rdSkillTreeSkills)) {
            return true;
        }
        return false;
    }
    public function is4thSkillTreeSkill($skillIndex)
    {
        if (1000 < $skillIndex) {
            return true;
        }
        return false;
    }
    public function isVIP($username)
    {
        global $dB;
        global $dB2;
        if (config("server_files", true) == "IGCN") {
            if (config("SQL_USE_2_DB", true)) {
                $vipData = $dB2->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$username]);
            } else {
                $vipData = $dB->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$username]);
            }
            if (0 < $vipData["Type"] && time() < strtotime($vipData["Date"])) {
                return true;
            }
            return false;
        }
        if (config("server_files", true) == "XTEAM") {
            if (config("SQL_USE_2_DB", true)) {
                $vipData = $dB2->query_fetch_single("SELECT * FROM MEMB_INFO WHERE memb___id = ?", [$username]);
            } else {
                $vipData = $dB->query_fetch_single("SELECT * FROM MEMB_INFO WHERE memb___id = ?", [$username]);
            }
            if (0 < $vipData["AccountLevel"] && time() < strtotime($vipData["AccountExpireDate"])) {
                return true;
            }
            return false;
        }
    }
    public function checkReqCurrency($username, $char, $currencyCode)
    {
        global $dB;
        global $dB2;
        $return = [];
        switch ($currencyCode) {
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
                $return["column"] = "Money";
                $return["table"] = "Character";
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
                $customItem = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$currencyCode]);
                $return["column"] = str_replace(" ", "_", $customItem["name"]);
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = $customItem["name"];
                if (1 <= $currencyCode && $currencyCode <= 3) {
                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                        $currency = $dB2->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$username]);
                    } else {
                        $currency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$username]);
                    }
                } else {
                    if ($currencyCode == "6") {
                        $currency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ? AND Name = ?", [$username, $char]);
                    } else {
                        $currency = $dB->query_fetch_single("SELECT " . $return["column"] . " FROM " . $return["table"] . " WHERE " . $return["ident"] . " = ?", [$username]);
                    }
                }
                $data = [];
                $data["currName"] = $return["name"];
                $data["currVal"] = $currency[$return["column"]];
                return $data;
        }
    }
    public function updateReqCurrency($username, $char, $currencyCode, $currencyAmount)
    {
        global $dB;
        global $dB2;
        $return = [];
        switch ($currencyCode) {
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
                $return["column"] = "Money";
                $return["table"] = "Character";
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
                $customItem = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$currencyCode]);
                $return["column"] = str_replace(" ", "_", $customItem["name"]);
                $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                $return["ident"] = "AccountID";
                $return["name"] = $customItem["name"];
                if (1 <= $currencyCode && $currencyCode <= 3) {
                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                        $update = $dB2->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " - ? WHERE " . $return["ident"] . " = ?", [$currencyAmount, $username]);
                    } else {
                        $update = $dB->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " - ? WHERE " . $return["ident"] . " = ?", [$currencyAmount, $username]);
                    }
                } else {
                    if ($currencyCode == "6") {
                        $update = $dB->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " - ? WHERE " . $return["ident"] . " = ? AND Name = ?", [$currencyAmount, $username, $char]);
                    } else {
                        $update = $dB->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " - ? WHERE " . $return["ident"] . " = ?", [$currencyAmount, $username]);
                    }
                }
                if ($update) {
                    return true;
                }
                return false;
        }
    }
    public function getCurrencyName($currencyCode)
    {
        global $dB;
        $return = [];
        switch ($currencyCode) {
            case 1:
                $return["name"] = lang("currency_platinum", true);
                break;
            case 2:
                $return["name"] = lang("currency_gold", true);
                break;
            case 3:
                $return["name"] = lang("currency_silver", true);
                break;
            case 4:
                $return["name"] = lang("currency_wcoinc", true);
                break;
            case 5:
                $return["name"] = lang("currency_gp", true);
                break;
            case 6:
                $return["name"] = "" . lang("currency_zen", true) . "";
                break;
            case 7:
                $return["name"] = "" . lang("currency_bless", true) . "";
                break;
            case 8:
                $return["name"] = "" . lang("currency_soul", true) . "";
                break;
            case 9:
                $return["name"] = "" . lang("currency_life", true) . "";
                break;
            case 10:
                $return["name"] = "" . lang("currency_chaos", true) . "";
                break;
            case 11:
                $return["name"] = "" . lang("currency_harmony", true) . "";
                break;
            case 12:
                $return["name"] = "" . lang("currency_creation", true) . "";
                break;
            case 13:
                $return["name"] = "" . lang("currency_guardian", true) . "";
                break;
            default:
                $customItem = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM WHERE ident = ?", [$currencyCode]);
                $return["name"] = $customItem["name"];
                return $return["name"];
        }
    }
    public function CharacterReset($username, $character_name, $userid)
    {
        global $dB;
        global $dB2;
        global $common;
        global $custom;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::Number($userid)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $character_name = Decode($character_name);
                if ($this->CharacterExists($character_name) && $this->CharacterBelongsToAccount($character_name, $username)) {
                    if (!$common->accountOnline($username)) {
                        $characterData = $this->CharacterData($character_name);
                        $resetLimit = 0;
                        if ($this->isVIP($username)) {
                            $isVIP = true;
                        } else {
                            $isVIP = false;
                        }
                        if ($characterData["mLevel"] == NULL) {
                            $characterData["mLevel"] = 0;
                        }
                        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "usercp.reset.xml");
                        if ($xml !== false) {
                            $resetConfig = [];
                            $bonusStats = 0;
                            $requiredPrice = 0;
                            $foundStage = false;
                            $fromNextStage = false;
                            $addedNextStage = false;
                            $req_items = [];
                            $i = 1;
                            foreach ($xml->resets->children() as $tag => $reset) {
                                if ($tag == "reset") {
                                    if ($resetLimit < intval($reset["req_reset_max"])) {
                                        $resetLimit = intval($reset["req_reset_max"]);
                                    }
                                    if (!$foundStage) {
                                        if (intval($reset["req_reset_min"]) <= $characterData[_CLMN_CHR_RSTS_] && $characterData[_CLMN_CHR_RSTS_] <= intval($reset["req_reset_max"])) {
                                            $resetConfig["id"] = intval($reset["id"]);
                                            $resetConfig["req_reset_min"] = intval($reset["req_reset_min"]);
                                            $resetConfig["req_reset_max"] = intval($reset["req_reset_max"]);
                                            $resetConfig["price_req"] = intval($reset["price_req"]);
                                            $resetConfig["price_type"] = intval($reset["price_type"]);
                                            $resetConfig["price_formula"] = intval($reset["price_formula"]);
                                            $resetConfig["reset_stats"] = intval($reset["reset_stats"]);
                                            $resetConfig["bonus_stats_type"] = intval($reset["bonus_stats_type"]);
                                            $resetConfig["bonus_stats_formula"] = intval($reset["bonus_stats_formula"]);
                                            $resetConfig["is_cred_reward"] = intval($reset["is_cred_reward"]);
                                            $resetConfig["credit_config"] = intval($reset["credit_config"]);
                                            $resetConfig["clear_ml"] = intval($reset["clear_ml"]);
                                            $resetConfig["clear_ml_tree"] = intval($reset["clear_ml_tree"]);
                                            $resetConfig["clear_4th_tree"] = intval($reset["clear_4th_tree"]);
                                            $resetConfig["apply_equip_check"] = intval($reset["apply_equip_check"]);
                                            $resetConfig["items_req"] = intval($reset["items_req"]);
                                            $resetConfig["map_after_reset"] = intval($reset["map_after_reset"]);
                                            $resetConfig["map_coord_x_after_reset"] = intval($reset["map_coord_x_after_reset"]);
                                            $resetConfig["map_coord_y_after_reset"] = intval($reset["map_coord_y_after_reset"]);
                                            if ($resetConfig["items_req"]) {
                                                $req_items = $reset->req_items->children();
                                            }
                                            if ($isVIP) {
                                                $resetConfig["price"] = intval($reset["price_vip"]);
                                                $resetConfig["req_lvl"] = intval($reset["req_lvl_vip"]);
                                                $resetConfig["req_mlvl"] = intval($reset["req_mlvl_vip"]);
                                                if ($resetConfig["bonus_stats_type"] == "1") {
                                                    $resetConfig["bonus_stats"] = intval($reset["bonus_stats_vip_" . $characterData["Class"]]);
                                                } else {
                                                    $resetConfig["bonus_stats"] = intval($reset["bonus_stats_vip"]);
                                                }
                                                $resetConfig["cred_reward"] = intval($reset["cred_reward_vip"]);
                                                $resetConfig["time"] = intval($reset["time_vip"]);
                                                $resetConfig["lvl_after_reset"] = intval($reset["lvl_after_reset_vip"]);
                                                $resetConfig["exp_after_reset"] = intval($reset["exp_after_reset_vip"]);
                                            } else {
                                                $resetConfig["price"] = intval($reset["price"]);
                                                $resetConfig["req_lvl"] = intval($reset["req_lvl"]);
                                                $resetConfig["req_mlvl"] = intval($reset["req_mlvl"]);
                                                if ($resetConfig["bonus_stats_type"] == "1") {
                                                    $resetConfig["bonus_stats"] = intval($reset["bonus_stats_" . $characterData["Class"]]);
                                                } else {
                                                    $resetConfig["bonus_stats"] = intval($reset["bonus_stats"]);
                                                }
                                                $resetConfig["cred_reward"] = intval($reset["cred_reward"]);
                                                $resetConfig["time"] = intval($reset["time"]);
                                                $resetConfig["lvl_after_reset"] = intval($reset["lvl_after_reset"]);
                                                $resetConfig["exp_after_reset"] = intval($reset["exp_after_reset"]);
                                            }
                                            if ($resetConfig["price_formula"] && mconfig("stage_price_separate") == "0") {
                                                $requiredPrice += ($characterData[_CLMN_CHR_RSTS_] + 1 - $resetConfig["req_reset_min"]) * $resetConfig["price"];
                                            } else {
                                                if ($resetConfig["price_formula"] && mconfig("stage_price_separate") == "1") {
                                                    $requiredPrice += ($characterData[_CLMN_CHR_RSTS_] + 1) * $resetConfig["price"];
                                                } else {
                                                    $requiredPrice = $resetConfig["price"];
                                                }
                                            }
                                            if ($resetConfig["bonus_stats_formula"] && mconfig("stage_price_separate") == "0") {
                                                $bonusStats += ($characterData[_CLMN_CHR_RSTS_] + 1 - $resetConfig["req_reset_min"]) * $resetConfig["bonus_stats"];
                                            } else {
                                                if ($resetConfig["bonus_stats_formula"] && mconfig("stage_price_separate") == "1") {
                                                    $bonusStats += ($characterData[_CLMN_CHR_RSTS_] + 1) * $resetConfig["bonus_stats"];
                                                } else {
                                                    $bonusStats = $resetConfig["bonus_stats"];
                                                }
                                            }
                                            $foundStage = true;
                                        } else {
                                            if (intval($reset["price_formula"]) && mconfig("stage_price_separate") == "0") {
                                                if ($isVIP) {
                                                    $requiredPrice += (intval($reset["req_reset_max"]) - intval($reset["req_reset_min"]) + 1) * intval($reset["price_vip"]);
                                                } else {
                                                    $requiredPrice += (intval($reset["req_reset_max"]) - intval($reset["req_reset_min"]) + 1) * intval($reset["price"]);
                                                }
                                            }
                                            if (intval($reset["bonus_stats_formula"]) && mconfig("stage_price_separate") == "0") {
                                                if ($isVIP) {
                                                    $tmpBonusStats = 0;
                                                    if (intval($reset["bonus_stats_type"]) == "1") {
                                                        $tmpBonusStats = intval($reset["bonus_stats_vip_" . $characterData["Class"]]);
                                                    } else {
                                                        $tmpBonusStats = intval($reset["bonus_stats_vip"]);
                                                    }
                                                    $bonusStats += (intval($reset["req_reset_max"]) - intval($reset["req_reset_min"]) + 1) * $tmpBonusStats;
                                                } else {
                                                    $tmpBonusStats = 0;
                                                    if (intval($reset["bonus_stats_type"]) == "1") {
                                                        $tmpBonusStats = intval($reset["bonus_stats_" . $characterData["Class"]]);
                                                    } else {
                                                        $tmpBonusStats = intval($reset["bonus_stats"]);
                                                    }
                                                    $bonusStats += (intval($reset["req_reset_max"]) - intval($reset["req_reset_min"]) + 1) * $tmpBonusStats;
                                                }
                                            }
                                        }
                                    } else {
                                        if ($fromNextStage && !$addedNextStage) {
                                            if ($isVIP) {
                                                $requiredPrice += intval($reset["price_vip"]);
                                                if (intval($reset["bonus_stats_type"]) == "1") {
                                                    $bonusStats += intval($reset["bonus_stats_vip_" . $characterData["Class"]]);
                                                } else {
                                                    $bonusStats += intval($reset["bonus_stats_vip"]);
                                                }
                                            } else {
                                                $requiredPrice += intval($reset["price"]);
                                                if (intval($reset["bonus_stats_type"]) == "1") {
                                                    $bonusStats += intval($reset["bonus_stats_" . $characterData["Class"]]);
                                                } else {
                                                    $bonusStats += intval($reset["bonus_stats"]);
                                                }
                                            }
                                            $addedNextStage = true;
                                        }
                                    }
                                }
                            }
                            if ($this->hasRequiredLevel($characterData[_CLMN_CHR_LVL_], $resetConfig["req_lvl"])) {
                                if ($this->hasRequiredMasterLevel($characterData["mLevel"], $resetConfig["req_mlvl"])) {
                                    if (0 < $resetConfig["time"]) {
                                        $req_time = false;
                                        $checkTime = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_CHARACTER_PROGRESS_LOGS \r\n                                                                              WHERE AccountID = ? AND Name = ? AND Type = ? AND NewValue > 0\r\n                                                                              ORDER BY Date DESC", [$username, $character_name, 1]);
                                        if ($checkTime["Date"] == NULL) {
                                            $req_time = true;
                                        } else {
                                            $resetTime = strtotime($checkTime["Date"]) + $resetConfig["time"] * 60;
                                            if ($resetTime <= time()) {
                                                $req_time = true;
                                            }
                                        }
                                    } else {
                                        $req_time = true;
                                    }
                                    if ($req_time) {
                                        if ($characterData[_CLMN_CHR_RSTS_] < $resetLimit) {
                                            if ($this->checkEquipment($username, $character_name, $resetConfig["apply_equip_check"], mconfig("check_equip_0"), mconfig("check_equip_1"), mconfig("check_equip_2"), mconfig("check_equip_3"), mconfig("check_equip_4"), mconfig("check_equip_5"), mconfig("check_equip_6"), mconfig("check_equip_7"), mconfig("check_equip_8"), mconfig("check_equip_9"), mconfig("check_equip_10"), mconfig("check_equip_11"), mconfig("check_equip_236"), mconfig("check_equip_237"), mconfig("check_equip_238"))) {
                                                if ($resetConfig["price_req"]) {
                                                    $reqCurrencyName = "";
                                                    $actualCurrency = $this->checkReqCurrency($username, $character_name, $resetConfig["price_type"]);
                                                    if ($requiredPrice <= $actualCurrency["currVal"]) {
                                                        $req_ok = true;
                                                        $accountLog = sprintf(lang("resetcharacter_txt_6", true), $requiredPrice, $actualCurrency["currName"]);
                                                    } else {
                                                        $req_ok = false;
                                                    }
                                                    $reqCurrencyName = $actualCurrency["currName"];
                                                } else {
                                                    $req_ok = true;
                                                }
                                                if ($req_ok) {
                                                    if ($resetConfig["items_req"]) {
                                                        $Items = new Items();
                                                        $req_items_ok = false;
                                                        $inventory = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = ? AND Name = ?), 2) AS items", [$username, $character_name]);
                                                        $inventory = $inventory["items"];
                                                        $invIndex = 12;
                                                        while ($invIndex < 173) {
                                                            $reqItemsIndex = 0;
                                                            foreach ($req_items as $innerTag => $item) {
                                                                if ($innerTag == "item") {
                                                                    $inv_item = $Items->ItemInfo(substr($inventory, __ITEM_LENGTH__ * $invIndex, __ITEM_LENGTH__));
                                                                    $curr_item = $Items->ItemInfo(strval($item["hexcode"]));
                                                                    if ($inv_item["sticklevel"] == NULL || empty($inv_item["sticklevel"])) {
                                                                        $inv_item["sticklevel"] = 0;
                                                                    }
                                                                    if ($inv_item["skill2"] == NULL || empty($inv_item["skill2"])) {
                                                                        $inv_item["skill2"] = 0;
                                                                    }
                                                                    if ($inv_item["luck2"] == NULL || empty($inv_item["luck2"])) {
                                                                        $inv_item["luck2"] = 0;
                                                                    }
                                                                    if ($inv_item["opt2"] == NULL || empty($inv_item["opt2"])) {
                                                                        $inv_item["opt2"] = 0;
                                                                    }
                                                                    if ($inv_item["exl2"] == NULL || empty($inv_item["exl2"])) {
                                                                        $inv_item["exl2"] = 0;
                                                                    }
                                                                    if ($inv_item["isanc"] == NULL || empty($inv_item["isanc"])) {
                                                                        $inv_item["isanc"] = 0;
                                                                    }
                                                                    if ($curr_item["sticklevel"] == NULL || empty($curr_item["sticklevel"])) {
                                                                        $curr_item["sticklevel"] = 0;
                                                                    }
                                                                    if ($curr_item["skill2"] == NULL || empty($curr_item["skill2"])) {
                                                                        $curr_item["skill2"] = 0;
                                                                    }
                                                                    if ($curr_item["luck2"] == NULL || empty($curr_item["luck2"])) {
                                                                        $curr_item["luck2"] = 0;
                                                                    }
                                                                    if ($curr_item["opt2"] == NULL || empty($curr_item["opt2"])) {
                                                                        $curr_item["opt2"] = 0;
                                                                    }
                                                                    if ($curr_item["exl2"] == NULL || empty($curr_item["exl2"])) {
                                                                        $curr_item["exl2"] = 0;
                                                                    }
                                                                    if ($curr_item["isanc"] == NULL || empty($curr_item["isanc"])) {
                                                                        $curr_item["isanc"] = 0;
                                                                    }
                                                                    $check_itemLevel = false;
                                                                    $check_itemOption = false;
                                                                    $check_itemDurability = false;
                                                                    $check_itemLuck = false;
                                                                    $check_itemSkill = false;
                                                                    $check_itemExcellent = false;
                                                                    $check_itemAncient = false;
                                                                    $check_itemSocket = false;
                                                                    $check_itemJog = false;
                                                                    $check_itemHarmony = false;
                                                                    if (intval($item["level"]) == 1) {
                                                                        if ($inv_item["level"] == $curr_item["level"]) {
                                                                            $check_itemLevel = true;
                                                                        }
                                                                    } else {
                                                                        $check_itemLevel = true;
                                                                    }
                                                                    if (intval($item["option"]) == 1) {
                                                                        if ($inv_item["opt2"] == $curr_item["opt2"]) {
                                                                            $check_itemOption = true;
                                                                        }
                                                                    } else {
                                                                        $check_itemOption = true;
                                                                    }
                                                                    if (intval($item["durability"]) == 1) {
                                                                        if ($inv_item["dur"] == $curr_item["dur"]) {
                                                                            $check_itemDurability = true;
                                                                        }
                                                                    } else {
                                                                        $check_itemDurability = true;
                                                                    }
                                                                    if (intval($item["luck"]) == 1) {
                                                                        if ($inv_item["luck2"] == $curr_item["luck2"]) {
                                                                            $check_itemLuck = true;
                                                                        }
                                                                    } else {
                                                                        $check_itemLuck = true;
                                                                    }
                                                                    if (intval($item["skill"]) == 1) {
                                                                        if ($inv_item["skill2"] == $curr_item["skill2"]) {
                                                                            $check_itemSkill = true;
                                                                        }
                                                                    } else {
                                                                        $check_itemSkill = true;
                                                                    }
                                                                    if (intval($item["excellent"]) == 1) {
                                                                        if ($inv_item["exl2"] == $curr_item["exl2"]) {
                                                                            $check_itemExcellent = true;
                                                                        }
                                                                    } else {
                                                                        $check_itemExcellent = true;
                                                                    }
                                                                    if (intval($item["ancient"]) == 1) {
                                                                        if ($inv_item["isanc"] == $curr_item["isanc"]) {
                                                                            $check_itemAncient = true;
                                                                        }
                                                                    } else {
                                                                        $check_itemAncient = true;
                                                                    }
                                                                    if (intval($item["socket"]) == 1) {
                                                                        if ($inv_item["soc1"] == $curr_item["soc1"] && $inv_item["soc2"] == $curr_item["soc2"] && $inv_item["soc3"] == $curr_item["soc3"] && $inv_item["soc4"] == $curr_item["soc4"] && $inv_item["soc5"] == $curr_item["soc5"]) {
                                                                            $check_itemSocket = true;
                                                                        }
                                                                    } else {
                                                                        $check_itemSocket = true;
                                                                    }
                                                                    if (intval($item["guardian"]) == 1) {
                                                                        if ($inv_item["jog_byte"] == $curr_item["jog_byte"]) {
                                                                            $check_itemJog = true;
                                                                        }
                                                                    } else {
                                                                        $check_itemJog = true;
                                                                    }
                                                                    if (intval($item["harmony"]) == 1) {
                                                                        if ($inv_item["harmony_byte"] == $curr_item["harmony_byte"] && $inv_item["harmonylvl_byte"] == $curr_item["harmonylvl_byte"]) {
                                                                            $check_itemHarmony = true;
                                                                        }
                                                                    } else {
                                                                        $check_itemHarmony = true;
                                                                    }
                                                                    if ($inv_item["type"] == $curr_item["type"] && $inv_item["id"] == $curr_item["id"] && $check_itemLevel && $check_itemOption && $check_itemDurability && $check_itemLuck && $check_itemSkill && $check_itemExcellent && $check_itemAncient && $check_itemSocket && $check_itemJog && $check_itemHarmony && 0 < $item["count"]) {
                                                                        $req_items->item[$reqItemsIndex]["count"] = intval($req_items->item[$reqItemsIndex]["count"]) - 1;
                                                                        $inventory = substr_replace($inventory, __ITEM_EMPTY__, $invIndex * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                    }
                                                                }
                                                                $reqItemsIndex++;
                                                            }
                                                            $invIndex++;
                                                        }
                                                        foreach ($req_items as $innerTag => $item) {
                                                            if (0 < $item["count"]) {
                                                                $req_items_ok = false;
                                                            } else {
                                                                $req_items_ok = true;
                                                            }
                                                        }
                                                    } else {
                                                        $req_items_ok = true;
                                                    }
                                                    if ($req_items_ok) {
                                                        loadModuleConfigs("usercp.greset");
                                                        $gr_bonus = mconfig("gresets_bonus_stats");
                                                        $gr_bonus_formula = mconfig("gresets_bonus_stats_formula");
                                                        loadModuleConfigs("usercp.reset");
                                                        if ($resetConfig["clear_ml_tree"] == "1") {
                                                            $magicList = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT MagicList FROM Character WHERE AccountID = ? AND Name = ?), 2) AS magicList", [$username, $character_name]);
                                                            $magicList = $magicList["magicList"];
                                                            $newMagicList = $magicList;
                                                            $count = 0;
                                                            $magicListSize = 900;
                                                            $skillSize = 6;
                                                            $skillEmpty = "FF0000";
                                                            if (132 <= config("server_files_season", true)) {
                                                                $magicListSize = 3700;
                                                                $skillSize = 10;
                                                                $skillEmpty = "FF00000000";
                                                            } else {
                                                                if (130 <= config("server_files_season", true)) {
                                                                    $magicListSize = 4500;
                                                                    $skillSize = 10;
                                                                    $skillEmpty = "FF00000000";
                                                                }
                                                            }
                                                            $i = 0;
                                                            while ($i < $magicListSize) {
                                                                $skill = NULL;
                                                                $skill = substr($magicList, $i, $skillSize);
                                                                $byte1 = substr($skill, 0, 2);
                                                                $byte2 = substr($skill, 2, 2);
                                                                $byte3 = substr($skill, 4, 2);
                                                                $dec1 = base_convert($byte1, 16, 10);
                                                                $dec3 = base_convert($byte3, 16, 10);
                                                                $bin2 = base_convert($byte2, 16, 2);
                                                                while (strlen($bin2) < 8) {
                                                                    $bin2 = "0" . $bin2;
                                                                }
                                                                $binx = "00000111";
                                                                $and = $bin2 & $binx;
                                                                $dec2 = base_convert($and, 2, 10);
                                                                if (0 < $and) {
                                                                    $index = $dec1 * $dec2 + $dec3;
                                                                } else {
                                                                    $index = $dec1;
                                                                }
                                                                if ($this->is3rdSkillTreeSkill($index)) {
                                                                    $dec22 = base_convert($byte2, 16, 10);
                                                                    $dec22 = floor($dec22 / 2);
                                                                    $dec22 = floor($dec22 / 2);
                                                                    $dec22 = floor($dec22 / 2);
                                                                    $skillLevel = $dec22;
                                                                    $newMagicList = substr_replace($newMagicList, $skillEmpty, $i, $skillSize);
                                                                    $count = $count + $skillLevel * 1;
                                                                }
                                                                $i += $skillSize;
                                                            }
                                                            $newMagicList = "0x" . $newMagicList;
                                                            $dB->query("UPDATE Character SET MagicList = " . $newMagicList . " WHERE AccountID = '" . $username . "' AND Name = '" . $character_name . "'");
                                                        }
                                                        if ($resetConfig["clear_ml"] == "1") {
                                                            $dB->query("UPDATE Character SET mLevel = 0, mlPoint = 0, mlExperience = 0, mlNextExp = 0 WHERE AccountID = ? AND Name = ?", [$username, $character_name]);
                                                        }
                                                        if (120 <= config("server_files_season", true)) {
                                                            if ($resetConfig["clear_ml"] == "1") {
                                                                $dB->query("UPDATE Character SET i4thSkillPoint = 0 WHERE AccountID = ? AND Name = ?", [$username, $character_name]);
                                                            }
                                                            if ($resetConfig["clear_4th_tree"] == "1") {
                                                                $magicList = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT MagicList FROM Character WHERE AccountID = ? AND Name = ?), 2) AS magicList", [$username, $character_name]);
                                                                $magicList = $magicList["magicList"];
                                                                $newMagicList = $magicList;
                                                                $count = 0;
                                                                $magicListSize = 900;
                                                                $skillSize = 6;
                                                                $skillEmpty = "FF0000";
                                                                if (132 <= config("server_files_season", true)) {
                                                                    $magicListSize = 3700;
                                                                    $skillSize = 10;
                                                                    $skillEmpty = "FF00000000";
                                                                } else {
                                                                    if (130 <= config("server_files_season", true)) {
                                                                        $magicListSize = 4500;
                                                                        $skillSize = 10;
                                                                        $skillEmpty = "FF00000000";
                                                                    }
                                                                }
                                                                $i = 0;
                                                                while ($i < $magicListSize) {
                                                                    $skill = NULL;
                                                                    $skill = substr($magicList, $i, $skillSize);
                                                                    $byte1 = substr($skill, 0, 2);
                                                                    $byte2 = substr($skill, 2, 2);
                                                                    $byte3 = substr($skill, 4, 2);
                                                                    $dec1 = base_convert($byte1, 16, 10);
                                                                    $dec3 = base_convert($byte3, 16, 10);
                                                                    $bin2 = base_convert($byte2, 16, 2);
                                                                    while (strlen($bin2) < 8) {
                                                                        $bin2 = "0" . $bin2;
                                                                    }
                                                                    $binx = "00000111";
                                                                    $and = $bin2 & $binx;
                                                                    $dec2 = base_convert($and, 2, 10);
                                                                    if (0 < $and) {
                                                                        $index = $dec1 * $dec2 + $dec3;
                                                                    } else {
                                                                        $index = $dec1;
                                                                    }
                                                                    if (1000 < $index) {
                                                                        $dec22 = base_convert($byte2, 16, 10);
                                                                        $dec22 = floor($dec22 / 2);
                                                                        $dec22 = floor($dec22 / 2);
                                                                        $dec22 = floor($dec22 / 2);
                                                                        $skillLevel = $dec22;
                                                                        $newMagicList = substr_replace($newMagicList, $skillEmpty, $i, $skillSize);
                                                                        $count = $count + $skillLevel * 1;
                                                                    }
                                                                    $i += $skillSize;
                                                                }
                                                                $newMagicList = "0x" . $newMagicList;
                                                                $dB->query("UPDATE Character SET MagicList = " . $newMagicList . " WHERE AccountID = '" . $username . "' AND Name = '" . $character_name . "'");
                                                            }
                                                        }
                                                        if ($resetConfig["reset_stats"] == "0") {
                                                            $update = $dB->query("UPDATE Character SET cLevel = ?, RESETS = RESETS + ?, LevelUpPoint = LevelUpPoint + ?, Experience = ?, MapNumber = ?, MapPosX = ?, MapPosY = ?\r\n                                                                      WHERE AccountID = ? AND Name = ?", [$resetConfig["lvl_after_reset"], 1, $bonusStats, $resetConfig["exp_after_reset"], $resetConfig["map_after_reset"], $resetConfig["map_coord_x_after_reset"], $resetConfig["map_coord_y_after_reset"], $username, $character_name]);
                                                        } else {
                                                            if ($resetConfig["reset_stats"] == "1") {
                                                                if (mconfig("keep_gr_bonus") && 0 < $gr_bonus && 0 < $characterData["Grand_Resets"]) {
                                                                    if ($gr_bonus_formula == "2") {
                                                                        $bonusStats += $characterData["RESETS"] * $gr_bonus;
                                                                    } else {
                                                                        if ($gr_bonus_formula == "1") {
                                                                            $bonusStats += $characterData["Grand_Resets"] * $gr_bonus;
                                                                        } else {
                                                                            if ($gr_bonus_formula == "0") {
                                                                                $bonusStats += $gr_bonus;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                if (in_array($characterData["Class"], $custom["class_filter"]["lord"])) {
                                                                    $update = $dB->query("UPDATE Character SET cLevel = ?, RESETS = RESETS + ?, LevelUpPoint = ?, Strength = ?, Dexterity = ?, Vitality = ?, Energy = ?, Leadership = ?, Experience = ?, MapNumber = ?, MapPosX = ?, MapPosY = ?\r\n                                                                          WHERE AccountID = ? AND Name = ?", [$resetConfig["lvl_after_reset"], 1, $bonusStats, 25, 25, 25, 25, 25, $resetConfig["exp_after_reset"], $resetConfig["map_after_reset"], $resetConfig["map_coord_x_after_reset"], $resetConfig["map_coord_y_after_reset"], $username, $character_name]);
                                                                } else {
                                                                    $update = $dB->query("UPDATE Character SET cLevel = ?, RESETS = RESETS + ?, LevelUpPoint = ?, Strength = ?, Dexterity = ?, Vitality = ?, Energy = ?, Experience = ?, MapNumber = ?, MapPosX = ?, MapPosY = ?\r\n                                                                          WHERE AccountID = ? AND Name = ?", [$resetConfig["lvl_after_reset"], 1, $bonusStats, 25, 25, 25, 25, $resetConfig["exp_after_reset"], $resetConfig["map_after_reset"], $resetConfig["map_coord_x_after_reset"], $resetConfig["map_coord_y_after_reset"], $username, $character_name]);
                                                                }
                                                            }
                                                        }
                                                        if ($update) {
                                                            if ($resetConfig["price_req"]) {
                                                                $this->updateReqCurrency($username, $character_name, $resetConfig["price_type"], $requiredPrice);
                                                            }
                                                            message("success", lang("success_8", true));
                                                            if ($inventory != NULL && $resetConfig["items_req"]) {
                                                                $updateInv = $dB->query("UPDATE Character SET Inventory = 0x" . $inventory . " WHERE AccountID = '" . $username . "' AND Name = '" . $character_name . "'");
                                                            }
                                                            $getResets = $dB->query_fetch_single("SELECT RESETS FROM Character WHERE AccountID = ? AND Name = ?", [$username, $character_name]);
                                                            $logDate = date("Y-m-d H:i:s", time());
                                                            $common->accountLogs($username, "reset", sprintf(lang("resetcharacter_txt_7", true), $character_name, $getResets["RESETS"]), $logDate);
                                                            $this->addCharacterProgressLog($username, $character_name, $getResets["RESETS"] - 1, $getResets["RESETS"], 1);
                                                            if ($resetConfig["is_cred_reward"]) {
                                                                try {
                                                                    $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                                                                    $creditSystem->setConfigId($resetConfig["credit_config"]);
                                                                    $configSettings = $creditSystem->showConfigs(true);
                                                                    switch ($configSettings["config_user_col_id"]) {
                                                                        case "userid":
                                                                            $creditSystem->setIdentifier($_SESSION["userid"]);
                                                                            break;
                                                                        case "username":
                                                                            $creditSystem->setIdentifier($_SESSION["username"]);
                                                                            break;
                                                                        case "character":
                                                                            $creditSystem->setIdentifier($character_name);
                                                                            $creditSystem->addCredits($resetConfig["cred_reward"]);
                                                                            $creditName = $dB->query_fetch_single("SELECT config_title FROM IMPERIAMUCMS_CREDITS_CONFIG WHERE config_id = ?", [$resetConfig["credit_config"]]);
                                                                            message("success", lang("reset_reward_1b", true) . $resetConfig["cred_reward"] . " " . $creditName["config_title"] . "! " . lang("reset_reward_1a", true));
                                                                            break;
                                                                        default:
                                                                            throw new Exception("Invalid identifier (credit system).");
                                                                    }
                                                                } catch (Exception $ex) {
                                                                }
                                                            }
                                                        } else {
                                                            message("error", lang("error_23", true));
                                                        }
                                                    } else {
                                                        message("error", lang("resetcharacter_txt_38", true));
                                                    }
                                                } else {
                                                    message("error", sprintf(lang("resetcharacter_txt_39", true), $reqCurrencyName));
                                                }
                                            } else {
                                                message("error", lang("resetcharacter_txt_37", true));
                                            }
                                        } else {
                                            message("error", lang("resetcharacter_txt_8", true));
                                        }
                                    } else {
                                        $wait = $resetTime - time();
                                        $hours = $wait / 3600;
                                        $wait = $wait % 3600;
                                        $minutes = $wait / 60;
                                        $seconds = $wait % 60;
                                        message("error", sprintf(lang("resetcharacter_txt_35", true), $hours, $minutes, $seconds));
                                    }
                                } else {
                                    message("error", lang("error_71", true));
                                }
                            } else {
                                message("error", lang("error_33", true));
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
    public function CharacterExists($character_name)
    {
        global $dB;
        if (check_value($character_name)) {
            $check = $dB->query_fetch_single("SELECT AccountID, Name, cLevel, LevelUpPoint, Class, Experience, Strength, Dexterity, Vitality, Energy, CONVERT(VARCHAR(MAX), MagicList, 2) AS MagicList, Money, Life, MaxLife, Mana, MaxMana, MapNumber, MapPosX, MapPosY, PkCount, PkLevel, PkTime, MDate, LDate, CtlCode, CONVERT(VARCHAR(MAX), Quest, 2) AS Quest, Leadership, ChatLimitTime, FruitPoint, RESETS, CONVERT(VARCHAR(MAX), Inventory, 2) AS Inventory, Married, MarryName, mLevel, mlPoint, mlExperience, mlNextExp, InventoryExpansion, WinDuels, LoseDuels, Grand_Resets FROM " . _TBL_CHR_ . " WHERE " . _CLMN_CHR_NAME_ . " = ?", [$character_name]);
            if (is_array($check)) {
                return true;
            }
        }
        return false;
    }
    public function CharacterBelongsToAccount($character_name, $username)
    {
        if (check_value($character_name) && check_value($username)) {
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $characterData = $this->CharacterData($character_name);
                if (is_array($characterData) && strtolower($characterData[_CLMN_CHR_ACCID_]) == strtolower($username)) {
                    return true;
                }
            }
        }
        return false;
    }
    public function CharacterData($character_name)
    {
        global $dB;
        if (check_value($character_name)) {
            if (config("server_files", true) == "IGCN") {
                if (100 <= config("server_files_season", true)) {
                    $result = $dB->query_fetch_single("SELECT AccountID, Name, cLevel, LevelUpPoint, Class, Experience, Strength, Dexterity, Vitality, Energy, CONVERT(VARCHAR(MAX), MagicList, 2) AS MagicList, Money, Life, MaxLife, Mana, MaxMana, MapNumber, MapPosX, MapPosY, PkCount, PkLevel, PkTime, MDate, LDate, CtlCode, CONVERT(VARCHAR(MAX), Quest, 2) AS Quest, Leadership, ChatLimitTime, FruitPoint, RESETS, CONVERT(VARCHAR(MAX), Inventory, 2) AS Inventory, Married, MarryName, mLevel, mlPoint, mlExperience, mlNextExp, InventoryExpansion, WinDuels, LoseDuels, Grand_Resets, Ruud FROM " . _TBL_CHR_ . " WHERE " . _CLMN_CHR_NAME_ . " = ?", [$character_name]);
                } else {
                    $result = $dB->query_fetch_single("SELECT AccountID, Name, cLevel, LevelUpPoint, Class, Experience, Strength, Dexterity, Vitality, Energy, CONVERT(VARCHAR(MAX), MagicList, 2) AS MagicList, Money, Life, MaxLife, Mana, MaxMana, MapNumber, MapPosX, MapPosY, PkCount, PkLevel, PkTime, MDate, LDate, CtlCode, CONVERT(VARCHAR(MAX), Quest, 2) AS Quest, Leadership, ChatLimitTime, FruitPoint, RESETS, CONVERT(VARCHAR(MAX), Inventory, 2) AS Inventory, Married, MarryName, mLevel, mlPoint, mlExperience, mlNextExp, InventoryExpansion, WinDuels, LoseDuels, Grand_Resets FROM " . _TBL_CHR_ . " WHERE " . _CLMN_CHR_NAME_ . " = ?", [$character_name]);
                }
            } else {
                if (config("server_files", true) == "XTEAM") {
                    $result = $dB->query_fetch_single("SELECT AccountID, Name, cLevel, LevelUpPoint, Class, Experience, Strength, Dexterity, Vitality, Energy, CONVERT(VARCHAR(MAX), MagicList, 2) AS MagicList, Money, Life, MaxLife, Mana, MaxMana, MapNumber, MapPosX, MapPosY, PkCount, PkLevel, PkTime, MDate, LDate, CtlCode, CONVERT(VARCHAR(MAX), Quest, 2) AS Quest, Leadership, ChatLimitTime, FruitPoint, RESETS, CONVERT(VARCHAR(MAX), Inventory, 2) AS Inventory, Grand_Resets FROM " . _TBL_CHR_ . " WHERE " . _CLMN_CHR_NAME_ . " = ?", [$character_name]);
                }
            }
            if (is_array($result)) {
                return $result;
            }
            return NULL;
        }
        return NULL;
    }
    public function hasRequiredLevel($level, $req_level)
    {
        if ($req_level <= $level) {
            return true;
        }
        return false;
    }
    public function hasRequiredMasterLevel($mlevel, $req_mlevel)
    {
        if ($req_mlevel <= $mlevel) {
            return true;
        }
        return false;
    }
    public function DeductCoins($character_name, $type, $amount)
    {
        global $dB;
        global $dB2;
        if (check_value($character_name) && check_value($type) && check_value($amount) && 1 <= $amount && Validator::Number($amount) && $this->CharacterExists($character_name)) {
            $characterData = $this->CharacterData($character_name);
            if (is_array($characterData) && ($type == "platinum" || $type == "gold" || $type == "silver")) {
                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                    $getCoins = $dB2->query_fetch_single("SELECT " . $type . " FROM MEMB_CREDITS WHERE memb___id = ?", [$characterData["AccountID"]]);
                } else {
                    $getCoins = $dB->query_fetch_single("SELECT " . $type . " FROM MEMB_CREDITS WHERE memb___id = ?", [$characterData["AccountID"]]);
                }
                if ($amount <= $getCoins[$type]) {
                    $type_used = $type . "_used";
                    if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                        $deduct = $dB2->query("UPDATE MEMB_CREDITS SET " . $type . " = " . $type . " - ?, " . $type . "_used = " . $type . "_used + ? WHERE memb___id = ?", [$amount, $amount, $characterData["AccountID"]]);
                    } else {
                        $deduct = $dB->query("UPDATE MEMB_CREDITS SET " . $type . " = " . $type . " - ?, " . $type . "_used = " . $type . "_used + ? WHERE memb___id = ?", [$amount, $amount, $characterData["AccountID"]]);
                    }
                    if ($deduct) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    public function DeductCashCoins($character_name, $type, $amount)
    {
        global $dB;
        if (check_value($character_name) && check_value($type) && check_value($amount) && 1 <= $amount && Validator::Number($amount) && $this->CharacterExists($character_name)) {
            $characterData = $this->CharacterData($character_name);
            if (is_array($characterData) && ($type == "WCoinC" || $type == "WCoinP" || $type == "GoblinPoint")) {
                if ($type == "WCoinC" && 100 <= config("server_files_season", true)) {
                    $type = "WCoin";
                }
                $getCoins = $dB->query_fetch_single("SELECT " . $type . " FROM T_InGameShop_Point WHERE AccountID = ?", [$characterData["AccountID"]]);
                if ($amount <= $getCoins[$type]) {
                    $deduct = $dB->query("UPDATE T_InGameShop_Point SET " . $type . " = " . $type . " - ? WHERE AccountID = ?", [$amount, $characterData["AccountID"]]);
                    if ($deduct) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    public function DeductZEN($character_name, $zen_amount)
    {
        global $dB;
        if (check_value($character_name) && check_value($zen_amount) && 1 <= $zen_amount && Validator::Number($zen_amount) && $this->CharacterExists($character_name)) {
            $characterData = $this->CharacterData($character_name);
            if (is_array($characterData) && $zen_amount <= $characterData[_CLMN_CHR_ZEN_]) {
                $deduct = $dB->query("UPDATE " . _TBL_CHR_ . " SET " . _CLMN_CHR_ZEN_ . " = " . _CLMN_CHR_ZEN_ . " - ? WHERE " . _CLMN_CHR_NAME_ . " = ?", [$zen_amount, $character_name]);
                if ($deduct) {
                    return true;
                }
            }
        }
        return false;
    }
    public function CharacterGReset($username, $character_name, $userid)
    {
        global $dB;
        global $dB2;
        global $common;
        global $custom;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::Number($userid)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $character_name = Decode($character_name);
                if ($this->CharacterExists($character_name) && $this->CharacterBelongsToAccount($character_name, $username)) {
                    if (!$common->accountOnline($username)) {
                        $characterData = $this->CharacterData($character_name);
                        if ($this->hasRequiredLevel($characterData[_CLMN_CHR_LVL_], mconfig("gresets_required_level"))) {
                            if ($this->hasRequiredReset($characterData[_CLMN_CHR_RSTS_])) {
                                if ($this->hasRequiredMasterLevel($characterData["mLevel"], mconfig("gresets_required_mlevel"))) {
                                    if (0 < mconfig("time")) {
                                        $req_time = false;
                                        $checkTime = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_CHARACTER_PROGRESS_LOGS \r\n                                                                              WHERE AccountID = ? AND Name = ? AND Type = ? AND NewValue > 0\r\n                                                                              ORDER BY Date DESC", [$username, $character_name, 2]);
                                        if ($checkTime["Date"] == NULL) {
                                            $req_time = true;
                                        } else {
                                            $resetTime = strtotime($checkTime["Date"]) + mconfig("time") * 60;
                                            if ($resetTime <= time()) {
                                                $req_time = true;
                                            }
                                        }
                                    } else {
                                        $req_time = true;
                                    }
                                    if ($req_time) {
                                        if ($this->isInGResetLimit($characterData["Grand_Resets"])) {
                                            if ($this->checkEquipment($username, $character_name, true, mconfig("check_equip_0"), mconfig("check_equip_1"), mconfig("check_equip_2"), mconfig("check_equip_3"), mconfig("check_equip_4"), mconfig("check_equip_5"), mconfig("check_equip_6"), mconfig("check_equip_7"), mconfig("check_equip_8"), mconfig("check_equip_9"), mconfig("check_equip_10"), mconfig("check_equip_11"), mconfig("check_equip_236"), mconfig("check_equip_237"), mconfig("check_equip_238"))) {
                                                if (mconfig("gresets_enable_requirement")) {
                                                    $greset_price = mconfig("gresets_price");
                                                    if (mconfig("gresets_price_formula")) {
                                                        $greset_price = $greset_price * ($characterData["Grand_Resets"] + 1);
                                                    }
                                                    if (mconfig("gresets_price_type") == "1") {
                                                        $deductCoins = $this->DeductCoins($character_name, "platinum", $greset_price);
                                                        if ($deductCoins) {
                                                            $req_ok = true;
                                                            $accountLog = sprintf(lang("resetcharacter_txt_6", true), $greset_price, lang("currency_platinum", true));
                                                        } else {
                                                            $req_ok = false;
                                                        }
                                                    } else {
                                                        if (mconfig("gresets_price_type") == "2") {
                                                            $deductCoins = $this->DeductCoins($character_name, "gold", $greset_price);
                                                            if ($deductCoins) {
                                                                $req_ok = true;
                                                                $accountLog = sprintf(lang("resetcharacter_txt_6", true), $greset_price, lang("currency_gold", true));
                                                            } else {
                                                                $req_ok = false;
                                                            }
                                                        } else {
                                                            if (mconfig("gresets_price_type") == "3") {
                                                                $deductCoins = $this->DeductCoins($character_name, "silver", $greset_price);
                                                                if ($deductCoins) {
                                                                    $req_ok = true;
                                                                    $accountLog = sprintf(lang("resetcharacter_txt_6", true), $greset_price, lang("currency_silver", true));
                                                                } else {
                                                                    $req_ok = false;
                                                                }
                                                            } else {
                                                                if (mconfig("gresets_price_type") == "4") {
                                                                    $deductCoins = $this->DeductCashCoins($character_name, "WCoinC", $greset_price);
                                                                    if ($deductCoins) {
                                                                        $req_ok = true;
                                                                        $accountLog = sprintf(lang("resetcharacter_txt_6", true), $greset_price, lang("currency_wcoinc", true));
                                                                    } else {
                                                                        $req_ok = false;
                                                                    }
                                                                } else {
                                                                    if (mconfig("gresets_price_type") == "5") {
                                                                        $deductCoins = $this->DeductCashCoins($character_name, "GoblinPoint", $greset_price);
                                                                        if ($deductCoins) {
                                                                            $req_ok = true;
                                                                            $accountLog = sprintf(lang("resetcharacter_txt_6", true), $greset_price, lang("currency_gp", true));
                                                                        } else {
                                                                            $req_ok = false;
                                                                        }
                                                                    } else {
                                                                        if (mconfig("gresets_price_type") == "6") {
                                                                            $deductZen = $this->DeductZEN($character_name, $greset_price);
                                                                            if ($deductZen) {
                                                                                $req_ok = true;
                                                                                $accountLog = sprintf(lang("resetcharacter_txt_6", true), $greset_price, "" . lang("currency_zen", true) . "");
                                                                            } else {
                                                                                $req_ok = false;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    $req_ok = true;
                                                }
                                                if ($req_ok) {
                                                    if (mconfig("gresets_clear_ml") == "1") {
                                                        $magicList = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT MagicList FROM Character WHERE AccountID = ? AND Name = ?), 2) AS magicList", [$username, $character_name]);
                                                        $magicList = $magicList["magicList"];
                                                        $newMagicList = $magicList;
                                                        $count = 0;
                                                        $magicListSize = 900;
                                                        $skillSize = 6;
                                                        $skillEmpty = "FF0000";
                                                        if (132 <= config("server_files_season", true)) {
                                                            $magicListSize = 3700;
                                                            $skillSize = 10;
                                                            $skillEmpty = "FF00000000";
                                                        } else {
                                                            if (130 <= config("server_files_season", true)) {
                                                                $magicListSize = 4500;
                                                                $skillSize = 10;
                                                                $skillEmpty = "FF00000000";
                                                            }
                                                        }
                                                        $i = 0;
                                                        while ($i < $magicListSize) {
                                                            $skill = NULL;
                                                            $skill = substr($magicList, $i, $skillSize);
                                                            $byte1 = substr($skill, 0, 2);
                                                            $byte2 = substr($skill, 2, 2);
                                                            $byte3 = substr($skill, 4, 2);
                                                            $dec1 = base_convert($byte1, 16, 10);
                                                            $dec3 = base_convert($byte3, 16, 10);
                                                            $bin2 = base_convert($byte2, 16, 2);
                                                            while (strlen($bin2) < 8) {
                                                                $bin2 = "0" . $bin2;
                                                            }
                                                            $binx = "00000111";
                                                            $and = $bin2 & $binx;
                                                            $dec2 = base_convert($and, 2, 10);
                                                            if (0 < $and) {
                                                                $index = $dec1 * $dec2 + $dec3;
                                                            } else {
                                                                $index = $dec1;
                                                            }
                                                            if ($this->is3rdSkillTreeSkill($index)) {
                                                                $dec22 = base_convert($byte2, 16, 10);
                                                                $dec22 = floor($dec22 / 2);
                                                                $dec22 = floor($dec22 / 2);
                                                                $dec22 = floor($dec22 / 2);
                                                                $skillLevel = $dec22;
                                                                $newMagicList = substr_replace($newMagicList, $skillEmpty, $i, $skillSize);
                                                                $count = $count + $skillLevel * 1;
                                                            }
                                                            $i += $skillSize;
                                                        }
                                                        $newMagicList = "0x" . $newMagicList;
                                                        $dB->query("UPDATE Character SET mLevel = 0, mlPoint = 0, mlExperience = 0, mlNextExp = 846093150, MagicList = " . $newMagicList . " WHERE AccountID = '" . $username . "' AND Name = '" . $character_name . "'");
                                                    }
                                                    if (0 < mconfig("decrease_resets")) {
                                                        if (0 <= $characterData["RESETS"] - mconfig("decrease_resets")) {
                                                            $newReset = $characterData["RESETS"] - mconfig("decrease_resets");
                                                        } else {
                                                            $newReset = 0;
                                                        }
                                                    } else {
                                                        $newReset = 0;
                                                    }
                                                    if (mconfig("gresets_reset_stats") == "0") {
                                                        if (mconfig("gresets_bonus_stats_formula") == "0") {
                                                            $bonus_stats = mconfig("gresets_bonus_stats");
                                                            $update = $dB->query("UPDATE Character SET cLevel = ?, RESETS = ?, Grand_Resets = Grand_Resets + ?, LevelUpPoint = LevelUpPoint + ?, Experience = ?\r\n                                                                          WHERE AccountID = ? AND Name = ?", [1, $newReset, 1, $bonus_stats, 0, $username, $character_name]);
                                                        } else {
                                                            if (mconfig("gresets_bonus_stats_formula") == "1") {
                                                                $bonus_stats = mconfig("gresets_bonus_stats") * ($characterData["Grand_Resets"] + 1);
                                                                $update = $dB->query("UPDATE Character SET cLevel = ?, RESETS = ?, Grand_Resets = Grand_Resets + ?, LevelUpPoint = LevelUpPoint + ?, Experience = ?\r\n                                                                          WHERE AccountID = ? AND Name = ?", [1, $newReset, 1, $bonus_stats, 0, $username, $character_name]);
                                                            } else {
                                                                if (mconfig("gresets_bonus_stats_formula") == "2") {
                                                                    $bonus_stats = mconfig("gresets_bonus_stats") * ($characterData["RESETS"] - 1);
                                                                    $update = $dB->query("UPDATE Character SET cLevel = ?, RESETS = ?, Grand_Resets = Grand_Resets + ?, LevelUpPoint = LevelUpPoint + ?, Experience = ?\r\n                                                                          WHERE AccountID = ? AND Name = ?", [1, $newReset, 1, $bonus_stats, 0, $username, $character_name]);
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        if (mconfig("gresets_reset_stats") == "1") {
                                                            if (mconfig("gresets_bonus_stats_formula") == "0") {
                                                                $bonus_stats = mconfig("gresets_bonus_stats");
                                                                if (in_array($characterData["Class"], $custom["class_filter"]["lord"])) {
                                                                    $update = $dB->query("UPDATE Character SET cLevel = ?, RESETS = ?, Grand_Resets = Grand_Resets + ?, LevelUpPoint = ?, Strength = ?, Dexterity = ?, Vitality = ?, Energy = ?, Leadership = ?, Experience = ?\r\n                                                                              WHERE AccountID = ? AND Name = ?", [1, $newReset, 1, $bonus_stats, 25, 25, 25, 25, 25, 0, $username, $character_name]);
                                                                } else {
                                                                    $update = $dB->query("UPDATE Character SET cLevel = ?, RESETS = ?, Grand_Resets = Grand_Resets + ?, LevelUpPoint = ?, Strength = ?, Dexterity = ?, Vitality = ?, Energy = ?, Experience = ?\r\n                                                                              WHERE AccountID = ? AND Name = ?", [1, $newReset, 1, $bonus_stats, 25, 25, 25, 25, 0, $username, $character_name]);
                                                                }
                                                            } else {
                                                                if (mconfig("gresets_bonus_stats_formula") == "1") {
                                                                    $bonus_stats = mconfig("gresets_bonus_stats") * ($characterData["Grand_Resets"] + 1);
                                                                    if (in_array($characterData["Class"], $custom["class_filter"]["lord"])) {
                                                                        $update = $dB->query("UPDATE Character SET cLevel = ?, RESETS = ?, Grand_Resets = Grand_Resets + ?, LevelUpPoint = ?, Strength = ?, Dexterity = ?, Vitality = ?, Energy = ?, Leadership = ?, Experience = ?\r\n                                                                              WHERE AccountID = ? AND Name = ?", [1, $newReset, 1, $bonus_stats, 25, 25, 25, 25, 25, 0, $username, $character_name]);
                                                                    } else {
                                                                        $update = $dB->query("UPDATE Character SET cLevel = ?, RESETS = ?, Grand_Resets = Grand_Resets + ?, LevelUpPoint = ?, Strength = ?, Dexterity = ?, Vitality = ?, Energy = ?, Experience = ?\r\n                                                                              WHERE AccountID = ? AND Name = ?", [1, $newReset, 1, $bonus_stats, 25, 25, 25, 25, 0, $username, $character_name]);
                                                                    }
                                                                } else {
                                                                    if (mconfig("gresets_bonus_stats_formula") == "2") {
                                                                        $bonus_stats = mconfig("gresets_bonus_stats") * ($characterData["RESETS"] - 1);
                                                                        if (in_array($characterData["Class"], $custom["class_filter"]["lord"])) {
                                                                            $update = $dB->query("UPDATE Character SET cLevel = ?, RESETS = ?, Grand_Resets = Grand_Resets + ?, LevelUpPoint = ?, Strength = ?, Dexterity = ?, Vitality = ?, Energy = ?, Leadership = ?, Experience = ?\r\n                                                                              WHERE AccountID = ? AND Name = ?", [1, $newReset, 1, $bonus_stats, 25, 25, 25, 25, 25, 0, $username, $character_name]);
                                                                        } else {
                                                                            $update = $dB->query("UPDATE Character SET cLevel = ?, RESETS = ?, Grand_Resets = Grand_Resets + ?, LevelUpPoint = ?, Strength = ?, Dexterity = ?, Vitality = ?, Energy = ?, Experience = ?\r\n                                                                              WHERE AccountID = ? AND Name = ?", [1, $newReset, 1, $bonus_stats, 25, 25, 25, 25, 0, $username, $character_name]);
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                    if ($update) {
                                                        message("success", lang("success_8", true));
                                                        $getGResets = $dB->query_fetch_single("SELECT Grand_Resets FROM Character WHERE AccountID = '" . $username . "' AND Name = '" . $character_name . "'");
                                                        $logDate = date("Y-m-d H:i:s", time());
                                                        $common->accountLogs($username, "greset", sprintf(lang("resetcharacter_txt_9", true), $character_name, $getGResets["Grand_Resets"]), $logDate);
                                                        $this->addCharacterProgressLog($username, $character_name, $getGResets["Grand_Resets"] - 1, $getGResets["Grand_Resets"], 2);
                                                        if (mconfig("gresets_enable_credit_reward")) {
                                                            if (mconfig("gresets_reward_formula") == 2) {
                                                                $reward_amount = mconfig("gresets_credits_reward") + mconfig("gresets_credits_reward2") * ($characterData["Grand_Resets"] + 1);
                                                            } else {
                                                                if (mconfig("gresets_reward_formula") == 1) {
                                                                    $reward_amount = mconfig("gresets_credits_reward") * ($characterData["Grand_Resets"] + 1);
                                                                } else {
                                                                    $reward_amount = mconfig("gresets_credits_reward");
                                                                }
                                                            }
                                                            try {
                                                                $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                                                                $creditSystem->setConfigId(mconfig("credit_config"));
                                                                $configSettings = $creditSystem->showConfigs(true);
                                                                switch ($configSettings["config_user_col_id"]) {
                                                                    case "userid":
                                                                        $creditSystem->setIdentifier($_SESSION["userid"]);
                                                                        break;
                                                                    case "username":
                                                                        $creditSystem->setIdentifier($_SESSION["username"]);
                                                                        break;
                                                                    case "character":
                                                                        $creditSystem->setIdentifier($character_name);
                                                                        $creditSystem->addCredits($reward_amount);
                                                                        message("success", lang("reset_reward_1b", true) . $reward_amount . lang("reset_reward_1c", true), lang("reset_reward_1a", true));
                                                                        break;
                                                                    default:
                                                                        throw new Exception("Invalid identifier (credit system).");
                                                                }
                                                            } catch (Exception $ex) {
                                                            }
                                                        }
                                                    } else {
                                                        message("error", lang("error_23", true));
                                                    }
                                                } else {
                                                    message("error", lang("error_34", true));
                                                }
                                            } else {
                                                message("error", lang("resetcharacter_txt_37", true));
                                            }
                                        } else {
                                            message("error", lang("resetcharacter_txt_10", true));
                                        }
                                    } else {
                                        $wait = $resetTime - time();
                                        $hours = $wait / 3600;
                                        $wait = $wait % 3600;
                                        $minutes = $wait / 60;
                                        $seconds = $wait % 60;
                                        message("error", sprintf(lang("greset_txt_8", true), $hours, $minutes, $seconds));
                                    }
                                } else {
                                    message("error", lang("error_71", true));
                                }
                            } else {
                                message("error", "Not enough resets.");
                            }
                        } else {
                            message("error", lang("error_33", true));
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
    public function hasRequiredReset($reset)
    {
        if (mconfig("gresets_required_reset") <= $reset) {
            return true;
        }
        return false;
    }
    public function isInGResetLimit($greset)
    {
        if ($greset < mconfig("gresets_limit")) {
            return true;
        }
        return false;
    }
    public function CharacterResetStats($username, $character_name, $userid)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::Number($userid)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $character_name = Decode($character_name);
                if ($this->CharacterExists($character_name) && $this->CharacterBelongsToAccount($character_name, $username)) {
                    if (!$common->accountOnline($username)) {
                        $characterData = $this->CharacterData($character_name);
                        if (mconfig("resetstats_enable_requirement")) {
                            if (mconfig("resetstats_price_type") == "1") {
                                $deductCoins = $this->DeductCoins($character_name, "platinum", mconfig("resetstats_price"));
                                if ($deductCoins) {
                                    $req_ok = true;
                                    $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("resetstats_price"), lang("currency_platinum", true));
                                } else {
                                    $req_ok = false;
                                }
                            } else {
                                if (mconfig("resetstats_price_type") == "2") {
                                    $deductCoins = $this->DeductCoins($character_name, "gold", mconfig("resetstats_price"));
                                    if ($deductCoins) {
                                        $req_ok = true;
                                        $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("resetstats_price"), lang("currency_gold", true));
                                    } else {
                                        $req_ok = false;
                                    }
                                } else {
                                    if (mconfig("resetstats_price_type") == "3") {
                                        $deductCoins = $this->DeductCoins($character_name, "silver", mconfig("resetstats_price"));
                                        if ($deductCoins) {
                                            $req_ok = true;
                                            $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("resetstats_price"), lang("currency_silver", true));
                                        } else {
                                            $req_ok = false;
                                        }
                                    } else {
                                        if (mconfig("resetstats_price_type") == "4") {
                                            $deductCoins = $this->DeductCashCoins($character_name, "WCoinC", mconfig("resetstats_price"));
                                            if ($deductCoins) {
                                                $req_ok = true;
                                                $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("resetstats_price"), lang("currency_wcoinc", true));
                                            } else {
                                                $req_ok = false;
                                            }
                                        } else {
                                            if (mconfig("resetstats_price_type") == "5") {
                                                $deductCoins = $this->DeductCashCoins($character_name, "GoblinPoint", mconfig("resetstats_price"));
                                                if ($deductCoins) {
                                                    $req_ok = true;
                                                    $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("resetstats_price"), lang("currency_gp", true));
                                                } else {
                                                    $req_ok = false;
                                                }
                                            } else {
                                                if (mconfig("resetstats_price_type") == "6") {
                                                    $deductZen = $this->DeductZEN($character_name, mconfig("resetstats_price"));
                                                    if ($deductZen) {
                                                        $req_ok = true;
                                                        $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("resetstats_price"), "" . lang("currency_zen", true) . "");
                                                    } else {
                                                        $req_ok = false;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $req_ok = true;
                        }
                        if ($req_ok) {
                            $new_stats = mconfig("resetstats_new_stats");
                            $chr_str = $characterData[_CLMN_CHR_STAT_STR_];
                            $chr_agi = $characterData[_CLMN_CHR_STAT_AGI_];
                            $chr_vit = $characterData[_CLMN_CHR_STAT_VIT_];
                            $chr_ene = $characterData[_CLMN_CHR_STAT_ENE_];
                            $chr_cmd = $characterData[_CLMN_CHR_STAT_CMD_];
                            if (1 <= $chr_cmd) {
                                $levelup_points = $chr_str + $chr_agi + $chr_vit + $chr_ene + $chr_cmd - $new_stats * 5;
                                if ($levelup_points < 1) {
                                    $levelup_points = 0;
                                }
                                $update_query = "UPDATE " . _TBL_CHR_ . " SET\r\n\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_STAT_STR_ . " = " . $new_stats . ",\r\n\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_STAT_AGI_ . " = " . $new_stats . ",\r\n\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_STAT_VIT_ . " = " . $new_stats . ",\r\n\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_STAT_ENE_ . " = " . $new_stats . ",\r\n\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_STAT_CMD_ . " = " . $new_stats . ",\r\n\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_LVLUP_POINT_ . " = " . _CLMN_CHR_LVLUP_POINT_ . " + " . $levelup_points . "\r\n\t\t\t\t\t\t\t\t\tWHERE " . _CLMN_CHR_NAME_ . " = '" . $character_name . "'";
                            } else {
                                $levelup_points = $chr_str + $chr_agi + $chr_vit + $chr_ene - $new_stats * 4;
                                if ($levelup_points < 1) {
                                    $levelup_points = 0;
                                }
                                $update_query = "UPDATE " . _TBL_CHR_ . " SET\r\n\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_STAT_STR_ . " = " . $new_stats . ",\r\n\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_STAT_AGI_ . " = " . $new_stats . ",\r\n\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_STAT_VIT_ . " = " . $new_stats . ",\r\n\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_STAT_ENE_ . " = " . $new_stats . ",\r\n\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_LVLUP_POINT_ . " = " . _CLMN_CHR_LVLUP_POINT_ . " + " . $levelup_points . "\r\n\t\t\t\t\t\t\t\t\tWHERE " . _CLMN_CHR_NAME_ . " = '" . $character_name . "'";
                            }
                            $update = $dB->query($update_query);
                            if ($update) {
                                message("success", lang("success_9", true));
                                $logDate = date("Y-m-d H:i:s", time());
                                $common->accountLogs($username, "resetstats", sprintf(lang("resetstats_txt_9", true), $character_name, $accountLog), $logDate);
                            } else {
                                message("error", lang("error_23", true));
                            }
                        } else {
                            message("error", lang("error_34", true));
                        }
                    } else {
                        message("error", lang("error_14", true));
                    }
                } else {
                    message("error", lang("error_35", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function CharacterClearPK($username, $character_name)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $character_name = Decode($character_name);
                if ($this->CharacterExists($character_name) && $this->CharacterBelongsToAccount($character_name, $username)) {
                    if (!$common->accountOnline($username)) {
                        $characterData = $this->CharacterData($character_name);
                        if (mconfig("clearpk_enable_requirement")) {
                            if (mconfig("clearpk_price_type") == "1") {
                                $deductCoins = $this->DeductCoins($character_name, "platinum", mconfig("clearpk_price"));
                                if ($deductCoins) {
                                    $req_ok = true;
                                    $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearpk_price"), lang("currency_platinum", true));
                                } else {
                                    $req_ok = false;
                                }
                            } else {
                                if (mconfig("clearpk_price_type") == "2") {
                                    $deductCoins = $this->DeductCoins($character_name, "gold", mconfig("clearpk_price"));
                                    if ($deductCoins) {
                                        $req_ok = true;
                                        $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearpk_price"), lang("currency_gold", true));
                                    } else {
                                        $req_ok = false;
                                    }
                                } else {
                                    if (mconfig("clearpk_price_type") == "3") {
                                        $deductCoins = $this->DeductCoins($character_name, "silver", mconfig("clearpk_price"));
                                        if ($deductCoins) {
                                            $req_ok = true;
                                            $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearpk_price"), lang("currency_silver", true));
                                        } else {
                                            $req_ok = false;
                                        }
                                    } else {
                                        if (mconfig("clearpk_price_type") == "4") {
                                            $deductCoins = $this->DeductCashCoins($character_name, "WCoinC", mconfig("clearpk_price"));
                                            if ($deductCoins) {
                                                $req_ok = true;
                                                $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearpk_price"), lang("currency_wcoinc", true));
                                            } else {
                                                $req_ok = false;
                                            }
                                        } else {
                                            if (mconfig("clearpk_price_type") == "5") {
                                                $deductCoins = $this->DeductCashCoins($character_name, "GoblinPoint", mconfig("clearpk_price"));
                                                if ($deductCoins) {
                                                    $req_ok = true;
                                                    $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearpk_price"), lang("currency_gp", true));
                                                } else {
                                                    $req_ok = false;
                                                }
                                            } else {
                                                if (mconfig("clearpk_price_type") == "6") {
                                                    $deductZen = $this->DeductZEN($character_name, mconfig("clearpk_price"));
                                                    if ($deductZen) {
                                                        $req_ok = true;
                                                        $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearpk_price"), "" . lang("currency_zen", true) . "");
                                                    } else {
                                                        $req_ok = false;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $req_ok = true;
                        }
                        if ($req_ok) {
                            $update = $dB->query("UPDATE " . _TBL_CHR_ . " SET\r\n\t\t\t\t\t\t\t" . _CLMN_CHR_PK_LEVEL_ . " = 3,\r\n\t\t\t\t\t\t\t" . _CLMN_CHR_PK_TIME_ . " = 0\r\n\t\t\t\t\t\t\tWHERE " . _CLMN_CHR_NAME_ . " = '" . $character_name . "'");
                            if ($update) {
                                message("success", lang("success_10", true));
                                $logDate = date("Y-m-d H:i:s", time());
                                $common->accountLogs($username, "clearpk", sprintf(lang("clearpk_txt_5", true), $character_name, $accountLog), $logDate);
                            } else {
                                message("error", lang("error_23", true));
                            }
                        } else {
                            message("error", lang("error_34", true));
                        }
                    } else {
                        message("error", lang("error_14", true));
                    }
                } else {
                    message("error", lang("error_36", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function CharacterUnstuck($username, $character_name)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $character_name = Decode($character_name);
                if ($this->CharacterExists($character_name) && $this->CharacterBelongsToAccount($character_name, $username)) {
                    if (!$common->accountOnline($username)) {
                        $characterData = $this->CharacterData($character_name);
                        if (mconfig("unstuck_enable_requirement")) {
                            if (mconfig("unstuck_price_type") == "1") {
                                $deductCoins = $this->DeductCoins($character_name, "platinum", mconfig("unstuck_price"));
                                if ($deductCoins) {
                                    $req_ok = true;
                                    $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("unstuck_price"), lang("currency_platinum", true));
                                } else {
                                    $req_ok = false;
                                }
                            } else {
                                if (mconfig("unstuck_price_type") == "2") {
                                    $deductCoins = $this->DeductCoins($character_name, "gold", mconfig("unstuck_price"));
                                    if ($deductCoins) {
                                        $req_ok = true;
                                        $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("unstuck_price"), lang("currency_gold", true));
                                    } else {
                                        $req_ok = false;
                                    }
                                } else {
                                    if (mconfig("unstuck_price_type") == "3") {
                                        $deductCoins = $this->DeductCoins($character_name, "silver", mconfig("unstuck_price"));
                                        if ($deductCoins) {
                                            $req_ok = true;
                                            $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("unstuck_price"), lang("currency_silver", true));
                                        } else {
                                            $req_ok = false;
                                        }
                                    } else {
                                        if (mconfig("unstuck_price_type") == "4") {
                                            $deductCoins = $this->DeductCashCoins($character_name, "WCoinC", mconfig("unstuck_price"));
                                            if ($deductCoins) {
                                                $req_ok = true;
                                                $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("unstuck_price"), lang("currency_wcoinc", true));
                                            } else {
                                                $req_ok = false;
                                            }
                                        } else {
                                            if (mconfig("unstuck_price_type") == "5") {
                                                $deductCoins = $this->DeductCashCoins($character_name, "GoblinPoint", mconfig("unstuck_price"));
                                                if ($deductCoins) {
                                                    $req_ok = true;
                                                    $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("unstuck_price"), lang("currency_gp", true));
                                                } else {
                                                    $req_ok = false;
                                                }
                                            } else {
                                                if (mconfig("unstuck_price_type") == "6") {
                                                    $deductZen = $this->DeductZEN($character_name, mconfig("unstuck_price"));
                                                    if ($deductZen) {
                                                        $req_ok = true;
                                                        $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("unstuck_price"), "" . lang("currency_zen", true) . "");
                                                    } else {
                                                        $req_ok = false;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $req_ok = true;
                        }
                        if ($req_ok) {
                            $update = $this->moveCharacter($character_name, 0, 125, 125);
                            if ($update) {
                                message("success", lang("success_11", true));
                                $logDate = date("Y-m-d H:i:s", time());
                                $common->accountLogs($username, "unstuck", sprintf(lang("unstuckcharacter_txt_4", true), $character_name, $accountLog), $logDate);
                            } else {
                                message("error", lang("error_23", true));
                            }
                        } else {
                            message("error", lang("error_34", true));
                        }
                    } else {
                        message("error", lang("error_14", true));
                    }
                } else {
                    message("error", lang("error_37", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function moveCharacter($character_name, $map = 0, $x = 125, $y = 125)
    {
        global $dB;
        if (check_value($character_name)) {
            $move = $dB->query("UPDATE " . _TBL_CHR_ . " SET " . _CLMN_CHR_MAP_ . " = ?, " . _CLMN_CHR_MAP_X_ . " = ?, " . _CLMN_CHR_MAP_Y_ . " = ? WHERE " . _CLMN_CHR_NAME_ . " = ?", [$map, $x, $y, $character_name]);
            if ($move) {
                return true;
            }
        }
    }
    public function CharacterAddStats($username, $character_name, $str = 0, $agi = 0, $vit = 0, $ene = 0, $com = 0)
    {
        global $dB;
        global $dB2;
        global $common;
        global $custom;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $character_name = Decode($character_name);
                if ($this->CharacterExists($character_name) && $this->CharacterBelongsToAccount($character_name, $username)) {
                    if (!$common->accountOnline($username)) {
                        $characterData = $this->CharacterData($character_name);
                        if ($str < 1) {
                            $str = 0;
                        }
                        if ($agi < 1) {
                            $agi = 0;
                        }
                        if ($vit < 1) {
                            $vit = 0;
                        }
                        if ($ene < 1) {
                            $ene = 0;
                        }
                        if ($com < 1) {
                            $com = 0;
                        }
                        $total_add_points = $str + $agi + $vit + $ene + $com;
                        if (mconfig("addstats_minimum_add_points") <= $total_add_points) {
                            if ($total_add_points <= $characterData[_CLMN_CHR_LVLUP_POINT_]) {
                                if (in_array($characterData["Class"], $custom["class_filter"]["lord"])) {
                                    $error = false;
                                } else {
                                    if (1 <= $com) {
                                        $error = true;
                                    } else {
                                        $error = false;
                                    }
                                }
                                if (!$error) {
                                    $max_stats = mconfig("addstats_max_stats");
                                    $sum_str = $str + $characterData[_CLMN_CHR_STAT_STR_];
                                    $sum_agi = $agi + $characterData[_CLMN_CHR_STAT_AGI_];
                                    $sum_vit = $vit + $characterData[_CLMN_CHR_STAT_VIT_];
                                    $sum_ene = $ene + $characterData[_CLMN_CHR_STAT_ENE_];
                                    $sum_com = $com + $characterData[_CLMN_CHR_STAT_CMD_];
                                    $error = false;
                                    if ($max_stats < $sum_str) {
                                        $error = true;
                                    }
                                    if ($max_stats < $sum_agi) {
                                        $error = true;
                                    }
                                    if ($max_stats < $sum_vit) {
                                        $error = true;
                                    }
                                    if ($max_stats < $sum_ene) {
                                        $error = true;
                                    }
                                    if ($max_stats < $sum_com) {
                                        $error = true;
                                    }
                                    if (!$error) {
                                        if (mconfig("addstats_enable_zen_requirement")) {
                                            $deductZen = $this->DeductZEN($character_name, mconfig("addstats_price_zen"));
                                            if ($deductZen) {
                                                $zen_ok = true;
                                                $accountLogZen = sprintf(lang("addstats_txt_12", true), number_format(mconfig("addstats_price_zen")));
                                            } else {
                                                $zen_ok = false;
                                            }
                                        } else {
                                            $zen_ok = true;
                                        }
                                        if ($zen_ok) {
                                            $query = $dB->query("UPDATE " . _TBL_CHR_ . " SET\r\n\t\t\t\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_STAT_STR_ . " = " . _CLMN_CHR_STAT_STR_ . " + " . $str . ",\r\n\t\t\t\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_STAT_AGI_ . " = " . _CLMN_CHR_STAT_AGI_ . " + " . $agi . ",\r\n\t\t\t\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_STAT_VIT_ . " = " . _CLMN_CHR_STAT_VIT_ . " + " . $vit . ",\r\n\t\t\t\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_STAT_ENE_ . " = " . _CLMN_CHR_STAT_ENE_ . " + " . $ene . ",\r\n\t\t\t\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_STAT_CMD_ . " = " . _CLMN_CHR_STAT_CMD_ . " + " . $com . ",\r\n\t\t\t\t\t\t\t\t\t\t\t\t" . _CLMN_CHR_LVLUP_POINT_ . " = " . _CLMN_CHR_LVLUP_POINT_ . " - " . $total_add_points . "\r\n\t\t\t\t\t\t\t\t\t\t\t\tWHERE " . _CLMN_CHR_NAME_ . " = '" . $character_name . "'");
                                            if ($query) {
                                                message("success", lang("success_17", true));
                                                $logDate = date("Y-m-d H:i:s", time());
                                                $common->accountLogs($username, "addstats", sprintf(lang("addstats_txt_13", true), $character_name, $accountLogZen), $logDate);
                                            } else {
                                                message("error", lang("error_23", true));
                                            }
                                        } else {
                                            message("error", lang("error_34", true));
                                        }
                                    } else {
                                        message("error", lang("error_53", true));
                                    }
                                } else {
                                    message("error", lang("error_52", true));
                                }
                            } else {
                                message("error", lang("error_51", true));
                            }
                        } else {
                            message("error", lang("error_54", true) . mconfig("addstats_minimum_add_points"));
                        }
                    } else {
                        message("error", lang("error_14", true));
                    }
                } else {
                    message("error", lang("error_38", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function AccountCharacter($username)
    {
        global $dB;
        global $config;
        if (check_value($username)) {
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                if ($config["server_files_season"] < 131) {
                    $result = $dB->query_fetch_single("SELECT * FROM " . _TBL_AC_ . " WHERE " . _CLMN_AC_ID_ . " = ?", [$username]);
                    if (is_array($result)) {
                        $characters = [];
                        if (check_value($result[_CLMN_GAMEID_1_])) {
                            $characters[] = $result[_CLMN_GAMEID_1_];
                        }
                        if (check_value($result[_CLMN_GAMEID_2_])) {
                            $characters[] = $result[_CLMN_GAMEID_2_];
                        }
                        if (check_value($result[_CLMN_GAMEID_3_])) {
                            $characters[] = $result[_CLMN_GAMEID_3_];
                        }
                        if (check_value($result[_CLMN_GAMEID_4_])) {
                            $characters[] = $result[_CLMN_GAMEID_4_];
                        }
                        if (check_value($result[_CLMN_GAMEID_5_])) {
                            $characters[] = $result[_CLMN_GAMEID_5_];
                        }
                        if (1 <= count($characters)) {
                            return $characters;
                        }
                        return NULL;
                    }
                    return NULL;
                }
                $result = $dB->query_fetch("SELECT Name FROM Character WHERE AccountID = ?", [$username]);
                $characters = [];
                $i = 0;
                foreach ($result as $thisChar) {
                    if (check_value($thisChar["Name"])) {
                        $characters[$i] = $thisChar["Name"];
                        $i++;
                    }
                }
                if (1 <= count($characters)) {
                    return $characters;
                }
                return NULL;
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }
    public function AccountCharacterIDC($username)
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
                $data = $dB->query_fetch_single("SELECT * FROM " . _TBL_AC_ . " WHERE " . _CLMN_AC_ID_ . " = ?", [$username]);
                if (is_array($data)) {
                    return $data[_CLMN_GAMEIDC_];
                }
            }
        }
    }
    public function GenerateCharacterClassAvatar($code = 0, $alt = true, $img_tags = true)
    {
        global $custom;
        if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
            $image = __PATH_TEMPLATE_ASSETS__ . "characters/" . $custom["character_class"][$code][2];
        } else {
            $image = __PATH_TEMPLATE_IMG__ . "character-avatars/" . $custom["character_class"][$code][2];
        }
        $name = $custom["character_class"][$code][0];
        if ($img_tags) {
            if ($alt) {
                return "<img class=\"tables-character-class-img\" src=\"" . $image . "\" title=\"" . $name . "\" alt=\"" . $name . "\"/>";
            }
            return "<img class=\"tables-character-class-img\" src=\"" . $image . "\" />";
        }
        return $image;
    }
    public function GenerateCharacterClassAvatar2($code = 0, $alt = true, $img_tags = true)
    {
        global $custom;
        if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
            $image = __PATH_TEMPLATE_ASSETS__ . "characters/" . $custom["character_class"][$code][2];
        } else {
            $image = __PATH_TEMPLATE__ . "images/character-avatars/" . $custom["character_class"][$code][2];
        }
        $name = $custom["character_class"][$code][0];
        if ($img_tags) {
            if ($alt) {
                return "<img class=\"char-class-img\" src=\"" . $image . "\" title=\"" . $name . "\" alt=\"" . $name . "\"/>";
            }
            return "<img class=\"char-class-img\" src=\"" . $image . "\" />";
        }
        return $image;
    }
    public function CharacterResetSkillTree($username, $character_name, $userid)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::Number($userid)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $character_name = Decode($character_name);
                if ($this->CharacterExists($character_name) && $this->CharacterBelongsToAccount($character_name, $username)) {
                    if (!$common->accountOnline($username)) {
                        $characterData = $this->CharacterData($character_name);
                        if (mconfig("clearst_required_level") <= $characterData[_CLMN_CHR_LVL_]) {
                            $class = $dB->query_fetch_single("SELECT Class FROM Character WHERE AccountID = ? AND Name = ?", [$username, $character_name]);
                            if ($class["Class"] == "2" || $class["Class"] == "3" || $class["Class"] == "18" || $class["Class"] == "19" || $class["Class"] == "34" || $class["Class"] == "35" || $class["Class"] == "49" || $class["Class"] == "50" || $class["Class"] == "65" || $class["Class"] == "66" || $class["Class"] == "82" || $class["Class"] == "83" || $class["Class"] == "97" || $class["Class"] == "98" || $class["Class"] == "114" || $class["Class"] == "7" || $class["Class"] == "23" || $class["Class"] == "39" || $class["Class"] == "54" || $class["Class"] == "70" || $class["Class"] == "87" || $class["Class"] == "102" || $class["Class"] == "118" || $class["Class"] == "131" || $class["Class"] == "135" || $class["Class"] == "147" || $class["Class"] == "151") {
                                if (mconfig("clearst_enable_requirement")) {
                                    if (mconfig("clearst_price_type") == "1") {
                                        $deductCoins = $this->DeductCoins($character_name, "platinum", mconfig("clearst_price"));
                                        if ($deductCoins) {
                                            $req_ok = true;
                                            $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearst_price"), lang("currency_platinum", true));
                                        } else {
                                            $req_ok = false;
                                        }
                                    } else {
                                        if (mconfig("clearst_price_type") == "2") {
                                            $deductCoins = $this->DeductCoins($character_name, "gold", mconfig("clearst_price"));
                                            if ($deductCoins) {
                                                $req_ok = true;
                                                $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearst_price"), lang("currency_gold", true));
                                            } else {
                                                $req_ok = false;
                                            }
                                        } else {
                                            if (mconfig("clearst_price_type") == "3") {
                                                $deductCoins = $this->DeductCoins($character_name, "silver", mconfig("clearst_price"));
                                                if ($deductCoins) {
                                                    $req_ok = true;
                                                    $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearst_price"), lang("currency_silver", true));
                                                } else {
                                                    $req_ok = false;
                                                }
                                            } else {
                                                if (mconfig("clearst_price_type") == "4") {
                                                    $deductCoins = $this->DeductCashCoins($character_name, "WCoinC", mconfig("clearst_price"));
                                                    if ($deductCoins) {
                                                        $req_ok = true;
                                                        $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearst_price"), lang("currency_wcoinc", true));
                                                    } else {
                                                        $req_ok = false;
                                                    }
                                                } else {
                                                    if (mconfig("clearst_price_type") == "5") {
                                                        $deductCoins = $this->DeductCashCoins($character_name, "GoblinPoint", mconfig("clearst_price"));
                                                        if ($deductCoins) {
                                                            $req_ok = true;
                                                            $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearst_price"), lang("currency_gp", true));
                                                        } else {
                                                            $req_ok = false;
                                                        }
                                                    } else {
                                                        if (mconfig("clearst_price_type") == "6") {
                                                            $deductZen = $this->DeductZEN($character_name, mconfig("clearst_price"));
                                                            if ($deductZen) {
                                                                $req_ok = true;
                                                                $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearst_price"), "" . lang("currency_zen", true) . "");
                                                            } else {
                                                                $req_ok = false;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $req_ok = true;
                                }
                                if ($req_ok) {
                                    $magicList = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT MagicList FROM Character WHERE AccountID = ? AND Name = ?), 2) AS magicList", [$username, $character_name]);
                                    $magicList = $magicList["magicList"];
                                    $newMagicList = $magicList;
                                    $count = 0;
                                    $magicListSize = 900;
                                    $skillSize = 6;
                                    $skillEmpty = "FF0000";
                                    if (132 <= config("server_files_season", true)) {
                                        $magicListSize = 3700;
                                        $skillSize = 10;
                                        $skillEmpty = "FF00000000";
                                    } else {
                                        if (130 <= config("server_files_season", true)) {
                                            $magicListSize = 4500;
                                            $skillSize = 10;
                                            $skillEmpty = "FF00000000";
                                        }
                                    }
                                    $i = 0;
                                    while ($i < $magicListSize) {
                                        $skill = NULL;
                                        $skill = substr($magicList, $i, $skillSize);
                                        if ($skill != $skillEmpty) {
                                            $byte1 = substr($skill, 0, 2);
                                            $byte2 = substr($skill, 2, 2);
                                            $byte3 = substr($skill, 4, 2);
                                            $dec1 = base_convert($byte1, 16, 10);
                                            $dec3 = base_convert($byte3, 16, 10);
                                            $bin2 = base_convert($byte2, 16, 2);
                                            while (strlen($bin2) < 8) {
                                                $bin2 = "0" . $bin2;
                                            }
                                            $binx = "00000111";
                                            $and = $bin2 & $binx;
                                            $dec2 = base_convert($and, 2, 10);
                                            if (0 < $and) {
                                                $index = $dec1 * $dec2 + $dec3;
                                            } else {
                                                $index = $dec1;
                                            }
                                            if ($this->is3rdSkillTreeSkill($index)) {
                                                $dec22 = base_convert($byte2, 16, 10);
                                                $dec22 = floor($dec22 / 2);
                                                $dec22 = floor($dec22 / 2);
                                                $dec22 = floor($dec22 / 2);
                                                $skillLevel = $dec22;
                                                $newMagicList = substr_replace($newMagicList, $skillEmpty, $i, $skillSize);
                                                $count = $count + $skillLevel * 1;
                                            }
                                        }
                                        $i += $skillSize;
                                    }
                                    $newMagicList = "0x" . $newMagicList;
                                    $update = $dB->query("UPDATE Character SET MagicList = " . $newMagicList . ", mlPoint = mlPoint + " . $count . " WHERE AccountID = '" . $username . "' AND Name = '" . $character_name . "'");
                                    if ($update) {
                                        message("success", sprintf(lang("resetst_txt_5", true), $character_name));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "resetskilltree", sprintf(lang("resetst_txt_6", true), $character_name, $accountLog), $logDate);
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                } else {
                                    message("error", lang("error_34", true));
                                }
                            } else {
                                message("error", lang("resetst_txt_7", true));
                            }
                        } else {
                            message("error", lang("error_33", true));
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
    public function CharacterReset4thSkillTree($username, $character_name, $userid)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::Number($userid)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $character_name = Decode($character_name);
                if ($this->CharacterExists($character_name) && $this->CharacterBelongsToAccount($character_name, $username)) {
                    if (!$common->accountOnline($username)) {
                        $characterData = $this->CharacterData($character_name);
                        if (mconfig("required_level") <= $characterData[_CLMN_CHR_LVL_]) {
                            $class = $dB->query_fetch_single("SELECT Class FROM Character WHERE AccountID = ? AND Name = ?", [$username, $character_name]);
                            if ($class["Class"] == "7" || $class["Class"] == "23" || $class["Class"] == "39" || $class["Class"] == "54" || $class["Class"] == "70" || $class["Class"] == "87" || $class["Class"] == "102" || $class["Class"] == "118" || $class["Class"] == "135" || $class["Class"] == "151") {
                                if (mconfig("enable_requirement")) {
                                    if (mconfig("price_type") == "1") {
                                        $deductCoins = $this->DeductCoins($character_name, "platinum", mconfig("price"));
                                        if ($deductCoins) {
                                            $req_ok = true;
                                            $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("price"), lang("currency_platinum", true));
                                        } else {
                                            $req_ok = false;
                                        }
                                    } else {
                                        if (mconfig("price_type") == "2") {
                                            $deductCoins = $this->DeductCoins($character_name, "gold", mconfig("price"));
                                            if ($deductCoins) {
                                                $req_ok = true;
                                                $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("price"), lang("currency_gold", true));
                                            } else {
                                                $req_ok = false;
                                            }
                                        } else {
                                            if (mconfig("price_type") == "3") {
                                                $deductCoins = $this->DeductCoins($character_name, "silver", mconfig("price"));
                                                if ($deductCoins) {
                                                    $req_ok = true;
                                                    $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("price"), lang("currency_silver", true));
                                                } else {
                                                    $req_ok = false;
                                                }
                                            } else {
                                                if (mconfig("price_type") == "4") {
                                                    $deductCoins = $this->DeductCashCoins($character_name, "WCoinC", mconfig("price"));
                                                    if ($deductCoins) {
                                                        $req_ok = true;
                                                        $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("price"), lang("currency_wcoinc", true));
                                                    } else {
                                                        $req_ok = false;
                                                    }
                                                } else {
                                                    if (mconfig("price_type") == "5") {
                                                        $deductCoins = $this->DeductCashCoins($character_name, "GoblinPoint", mconfig("price"));
                                                        if ($deductCoins) {
                                                            $req_ok = true;
                                                            $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("price"), lang("currency_gp", true));
                                                        } else {
                                                            $req_ok = false;
                                                        }
                                                    } else {
                                                        if (mconfig("price_type") == "6") {
                                                            $deductZen = $this->DeductZEN($character_name, mconfig("price"));
                                                            if ($deductZen) {
                                                                $req_ok = true;
                                                                $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("price"), "" . lang("currency_zen", true) . "");
                                                            } else {
                                                                $req_ok = false;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $req_ok = true;
                                }
                                if ($req_ok) {
                                    $_4thSkillTreeData = $dB->query_fetch_single("\r\n                                        SELECT CONVERT(VARCHAR(2080), db4thSkill, 2) as skillMain,\r\n                                        CONVERT(VARCHAR(340), db4thSide, 2) as skillSide \r\n                                        FROM Character \r\n                                        WHERE AccountID = ? AND Name = ?", [$username, $character_name]);
                                    $total4thPoints = 0;
                                    $skillMainSize = 2080;
                                    $skillSideSize = 340;
                                    if ($_4thSkillTreeData["skillMain"] != NULL) {
                                        $i = 0;
                                        while ($i < $skillMainSize) {
                                            $skill = NULL;
                                            $skill = substr($_4thSkillTreeData["skillMain"], $i, 16);
                                            if ($skill != "FFFFFFFFFFFFFFFF") {
                                                $skillLvl = substr($skill, 12, 2);
                                                $total4thPoints += $skillLvl * 1;
                                            }
                                            $i += 16;
                                        }
                                    }
                                    if ($_4thSkillTreeData["skillSide"] != NULL) {
                                        $i = 0;
                                        while ($i < $skillSideSize) {
                                            $skill = NULL;
                                            $skill = substr($_4thSkillTreeData["skillSide"], $i, 34);
                                            if ($skill != "FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF") {
                                                $skillLvl = substr($skill, 8, 2);
                                                $total4thPoints += $skillLvl * 1;
                                            }
                                            $i += 34;
                                        }
                                    }
                                    $update = $dB->query("UPDATE Character SET db4thSkill = CONVERT(varbinary(1040), ?), db4thSide = CONVERT(varbinary(170), ?), i4thSkillPoint = ? WHERE AccountID = ? AND Name = ?", [NULL, NULL, $total4thPoints, $username, $character_name]);
                                    if ($update) {
                                        message("success", sprintf(lang("reset4thst_txt_8", true), $character_name));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "reset4thskilltree", sprintf(lang("reset4thst_txt_9", true), $character_name, $accountLog), $logDate);
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                } else {
                                    message("error", lang("error_34", true));
                                }
                            } else {
                                message("error", lang("reset4thst_txt_7", true));
                            }
                        } else {
                            message("error", lang("error_33", true));
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
    public function CharacterClearEventInventory($username, $character_name)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $character_name = Decode($character_name);
                if ($this->CharacterExists($character_name) && $this->CharacterBelongsToAccount($character_name, $username)) {
                    if (!$common->accountOnline($username)) {
                        $checkEventInventory = $dB->query_fetch_single("\r\n                            SELECT TOP 1 Name FROM T_Event_Inventory \r\n                            WHERE AccountID = ? AND Name = ?", [$username, $character_name]);
                        if (is_array($checkEventInventory)) {
                            if (mconfig("enable_requirement")) {
                                if (mconfig("price_type") == "1") {
                                    $deductCoins = $this->DeductCoins($character_name, "platinum", mconfig("price"));
                                    if ($deductCoins) {
                                        $req_ok = true;
                                        $accountLog = sprintf(lang("cleareventinv_txt_10", true), mconfig("price"), lang("currency_platinum", true));
                                    } else {
                                        $req_ok = false;
                                    }
                                } else {
                                    if (mconfig("price_type") == "2") {
                                        $deductCoins = $this->DeductCoins($character_name, "gold", mconfig("price"));
                                        if ($deductCoins) {
                                            $req_ok = true;
                                            $accountLog = sprintf(lang("cleareventinv_txt_10", true), mconfig("price"), lang("currency_gold", true));
                                        } else {
                                            $req_ok = false;
                                        }
                                    } else {
                                        if (mconfig("price_type") == "3") {
                                            $deductCoins = $this->DeductCoins($character_name, "silver", mconfig("price"));
                                            if ($deductCoins) {
                                                $req_ok = true;
                                                $accountLog = sprintf(lang("cleareventinv_txt_10", true), mconfig("price"), lang("currency_silver", true));
                                            } else {
                                                $req_ok = false;
                                            }
                                        } else {
                                            if (mconfig("price_type") == "4") {
                                                $deductCoins = $this->DeductCashCoins($character_name, "WCoinC", mconfig("price"));
                                                if ($deductCoins) {
                                                    $req_ok = true;
                                                    $accountLog = sprintf(lang("cleareventinv_txt_10", true), mconfig("price"), lang("currency_wcoinc", true));
                                                } else {
                                                    $req_ok = false;
                                                }
                                            } else {
                                                if (mconfig("price_type") == "5") {
                                                    $deductCoins = $this->DeductCashCoins($character_name, "GoblinPoint", mconfig("price"));
                                                    if ($deductCoins) {
                                                        $req_ok = true;
                                                        $accountLog = sprintf(lang("cleareventinv_txt_10", true), mconfig("price"), lang("currency_gp", true));
                                                    } else {
                                                        $req_ok = false;
                                                    }
                                                } else {
                                                    if (mconfig("price_type") == "6") {
                                                        $deductZen = $this->DeductZEN($character_name, mconfig("price"));
                                                        if ($deductZen) {
                                                            $req_ok = true;
                                                            $accountLog = sprintf(lang("cleareventinv_txt_10", true), mconfig("price"), "" . lang("currency_zen", true) . "");
                                                        } else {
                                                            $req_ok = false;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            } else {
                                $req_ok = true;
                            }
                            if ($req_ok) {
                                $emptyInv = "0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF";
                                $update = $dB->query("\r\n                                    UPDATE T_Event_Inventory SET Inventory = " . $emptyInv . "\r\n                                    WHERE AccountID = ? AND Name = ?", [$username, $character_name]);
                                if ($update) {
                                    message("success", sprintf(lang("cleareventinv_txt_8", true), $character_name));
                                    $logDate = date("Y-m-d H:i:s", time());
                                    $common->accountLogs($username, "cleareventinv", sprintf(lang("cleareventinv_txt_9", true), $character_name, $accountLog), $logDate);
                                } else {
                                    message("error", lang("error_23", true));
                                }
                            } else {
                                message("error", lang("error_34", true));
                            }
                        } else {
                            message("error", sprintf(lang("cleareventinv_txt_7", true), $character_name));
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
    public function CharacterResetTrees($username, $character_name, $userid)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::Number($userid)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $character_name = Decode($character_name);
                if ($this->CharacterExists($character_name) && $this->CharacterBelongsToAccount($character_name, $username)) {
                    if (!$common->accountOnline($username)) {
                        $characterData = $this->CharacterData($character_name);
                        if (mconfig("required_level") <= $characterData[_CLMN_CHR_LVL_]) {
                            $class = $dB->query_fetch_single("SELECT Class FROM Character WHERE AccountID = ? AND Name = ?", [$username, $character_name]);
                            if ($class["Class"] == "2" || $class["Class"] == "3" || $class["Class"] == "18" || $class["Class"] == "19" || $class["Class"] == "34" || $class["Class"] == "35" || $class["Class"] == "49" || $class["Class"] == "50" || $class["Class"] == "65" || $class["Class"] == "66" || $class["Class"] == "82" || $class["Class"] == "83" || $class["Class"] == "97" || $class["Class"] == "98" || $class["Class"] == "114" || $class["Class"] == "7" || $class["Class"] == "23" || $class["Class"] == "39" || $class["Class"] == "54" || $class["Class"] == "70" || $class["Class"] == "87" || $class["Class"] == "102" || $class["Class"] == "118" || $class["Class"] == "131" || $class["Class"] == "135" || $class["Class"] == "147" || $class["Class"] == "151") {
                                if (mconfig("enable_requirement")) {
                                    if (mconfig("price_type") == "1") {
                                        $deductCoins = $this->DeductCoins($character_name, "platinum", mconfig("price"));
                                        if ($deductCoins) {
                                            $req_ok = true;
                                            $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("price"), lang("currency_platinum", true));
                                        } else {
                                            $req_ok = false;
                                        }
                                    } else {
                                        if (mconfig("price_type") == "2") {
                                            $deductCoins = $this->DeductCoins($character_name, "gold", mconfig("price"));
                                            if ($deductCoins) {
                                                $req_ok = true;
                                                $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("price"), lang("currency_gold", true));
                                            } else {
                                                $req_ok = false;
                                            }
                                        } else {
                                            if (mconfig("price_type") == "3") {
                                                $deductCoins = $this->DeductCoins($character_name, "silver", mconfig("price"));
                                                if ($deductCoins) {
                                                    $req_ok = true;
                                                    $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("price"), lang("currency_silver", true));
                                                } else {
                                                    $req_ok = false;
                                                }
                                            } else {
                                                if (mconfig("price_type") == "4") {
                                                    $deductCoins = $this->DeductCashCoins($character_name, "WCoinC", mconfig("price"));
                                                    if ($deductCoins) {
                                                        $req_ok = true;
                                                        $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("price"), lang("currency_wcoinc", true));
                                                    } else {
                                                        $req_ok = false;
                                                    }
                                                } else {
                                                    if (mconfig("price_type") == "5") {
                                                        $deductCoins = $this->DeductCashCoins($character_name, "GoblinPoint", mconfig("price"));
                                                        if ($deductCoins) {
                                                            $req_ok = true;
                                                            $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("price"), lang("currency_gp", true));
                                                        } else {
                                                            $req_ok = false;
                                                        }
                                                    } else {
                                                        if (mconfig("price_type") == "6") {
                                                            $deductZen = $this->DeductZEN($character_name, mconfig("price"));
                                                            if ($deductZen) {
                                                                $req_ok = true;
                                                                $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("price"), "" . lang("currency_zen", true) . "");
                                                            } else {
                                                                $req_ok = false;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $req_ok = true;
                                }
                                if ($req_ok) {
                                    $magicList = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT MagicList FROM Character WHERE AccountID = ? AND Name = ?), 2) AS magicList", [$username, $character_name]);
                                    $magicList = $magicList["magicList"];
                                    $newMagicList = $magicList;
                                    $count = 0;
                                    $magicListSize = 900;
                                    $skillSize = 6;
                                    $skillEmpty = "FF0000";
                                    if (132 <= config("server_files_season", true)) {
                                        $magicListSize = 3700;
                                        $skillSize = 10;
                                        $skillEmpty = "FF00000000";
                                    } else {
                                        if (130 <= config("server_files_season", true)) {
                                            $magicListSize = 4500;
                                            $skillSize = 10;
                                            $skillEmpty = "FF00000000";
                                        }
                                    }
                                    $i = 0;
                                    while ($i < $magicListSize) {
                                        $skill = NULL;
                                        $skill = substr($magicList, $i, $skillSize);
                                        $byte1 = substr($skill, 0, 2);
                                        $byte2 = substr($skill, 2, 2);
                                        $byte3 = substr($skill, 4, 2);
                                        $dec1 = base_convert($byte1, 16, 10);
                                        $dec3 = base_convert($byte3, 16, 10);
                                        $bin2 = base_convert($byte2, 16, 2);
                                        while (strlen($bin2) < 8) {
                                            $bin2 = "0" . $bin2;
                                        }
                                        $binx = "00000111";
                                        $and = $bin2 & $binx;
                                        $dec2 = base_convert($and, 2, 10);
                                        if (0 < $and) {
                                            $index = $dec1 * $dec2 + $dec3;
                                        } else {
                                            $index = $dec1;
                                        }
                                        if ($this->is3rdSkillTreeSkill($index)) {
                                            $dec22 = base_convert($byte2, 16, 10);
                                            $dec22 = floor($dec22 / 2);
                                            $dec22 = floor($dec22 / 2);
                                            $dec22 = floor($dec22 / 2);
                                            $skillLevel = $dec22;
                                            $newMagicList = substr_replace($newMagicList, $skillEmpty, $i, $skillSize);
                                            $count = $count + $skillLevel * 1;
                                        }
                                        $i += $skillSize;
                                    }
                                    $newMagicList = "0x" . $newMagicList;
                                    $newMasterPoints = $characterData["mLevel"];
                                    if (400 < $newMasterPoints) {
                                        $newMasterPoints = 400;
                                    }
                                    $update = $dB->query("UPDATE Character SET MagicList = " . $newMagicList . ", mlPoint = " . $newMasterPoints . " WHERE AccountID = '" . $username . "' AND Name = '" . $character_name . "'");
                                    if (400 < $characterData["mLevel"] && ($class["Class"] == "7" || $class["Class"] == "23" || $class["Class"] == "39" || $class["Class"] == "54" || $class["Class"] == "70" || $class["Class"] == "87" || $class["Class"] == "102" || $class["Class"] == "118" || $class["Class"] == "135")) {
                                        $update2 = $dB->query("UPDATE Character SET db4thSkill = CONVERT(varbinary(1040), ?), db4thSide = CONVERT(varbinary(170), ?), i4thSkillPoint = ? WHERE AccountID = ? AND Name = ?", [NULL, NULL, $characterData["mLevel"] - 400, $username, $character_name]);
                                    }
                                    if ($update) {
                                        message("success", sprintf(lang("cleartrees_txt_9", true), $character_name));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "cleartrees", sprintf(lang("cleartrees_txt_8", true), $character_name, $accountLog), $logDate);
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                } else {
                                    message("error", lang("error_34", true));
                                }
                            } else {
                                message("error", lang("resetst_txt_7", true));
                            }
                        } else {
                            message("error", lang("error_33", true));
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
    public function clearInventory($username, $character_name)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $character_name = Decode($character_name);
                if ($this->CharacterExists($character_name) && $this->CharacterBelongsToAccount($character_name, $username)) {
                    if (!$common->accountOnline($username)) {
                        if (mconfig("clear_equip")) {
                            if (132 <= config("server_files_season", true)) {
                                $reset = $dB->query("UPDATE " . _TBL_CHR_ . " SET Inventory = 0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF\r\n                                 WHERE " . _CLMN_CHR_NAME_ . " = ? AND " . _CLMN_CHR_ACCID_ . " = ?", [$character_name, $username]);
                            } else {
                                $reset = $dB->query("UPDATE " . _TBL_CHR_ . " SET Inventory = 0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF\r\n                                 WHERE " . _CLMN_CHR_NAME_ . " = ? AND " . _CLMN_CHR_ACCID_ . " = ?", [$character_name, $username]);
                            }
                            $inventory = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = ? AND Name = ?), 2) AS Inventory", [$username, $character_name]);
                            $inventory = $inventory["Inventory"];
                            $oldInventory = "0x" . $inventory;
                        } else {
                            $inventory = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = ? AND Name = ?), 2) AS Inventory", [$username, $character_name]);
                            $inventory = $inventory["Inventory"];
                            $oldInventory = "0x" . $inventory;
                            $empty = __ITEM_EMPTY__;
                            $i = 0;
                            while ($i < 237) {
                                if (11 < $i && $i < 236) {
                                    $inventory = substr_replace($inventory, $empty, $i * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                }
                                $i++;
                            }
                            $inventory = "0x" . $inventory;
                            $reset = $dB->query("UPDATE " . _TBL_CHR_ . " SET Inventory = " . $inventory . " WHERE " . _CLMN_CHR_NAME_ . " = ? AND " . _CLMN_CHR_ACCID_ . " = ?", [$character_name, $username]);
                        }
                        if ($reset) {
                            message("success", lang("clearinv_txt_6", true));
                            $logDate = date("Y-m-d H:i:s", time());
                            $common->accountLogs($username, "clearinv", sprintf(lang("clearinv_txt_7", true), $character_name), $logDate);
                            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_CLEAR_INV_LOGS (date, AccountID, Name, IP, old_inventory) \r\n                                                  VALUES ('" . date("Y-m-d H:i:s", time()) . "', '" . $username . "', '" . $character_name . "', '" . $_SERVER["REMOTE_ADDR"] . "', " . $oldInventory . ")");
                        } else {
                            message("error", lang("error_23", true));
                        }
                    } else {
                        message("error", lang("error_14", true));
                    }
                } else {
                    message("error", lang("error_37", true));
                }
            } else {
                message("error", lang("error_23", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function CharacterResetSkills($username, $character_name, $userid)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::Number($userid)) {
                $error = true;
            }
            if (!Validator::UsernameLength($username)) {
                $error = true;
            }
            if (!Validator::AlphaNumeric($username)) {
                $error = true;
            }
            if (!$error) {
                $character_name = Decode($character_name);
                if ($this->CharacterExists($character_name) && $this->CharacterBelongsToAccount($character_name, $username)) {
                    if (!$common->accountOnline($username)) {
                        $characterData = $this->CharacterData($character_name);
                        if (mconfig("clearskills_required_level") <= $characterData[_CLMN_CHR_LVL_]) {
                            if (mconfig("clearskills_enable_requirement")) {
                                if (mconfig("clearskills_price_type") == "1") {
                                    $deductCoins = $this->DeductCoins($character_name, "platinum", mconfig("clearskills_price"));
                                    if ($deductCoins) {
                                        $req_ok = true;
                                        $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearskills_price"), lang("currency_platinum", true));
                                    } else {
                                        $req_ok = false;
                                    }
                                } else {
                                    if (mconfig("clearskills_price_type") == "2") {
                                        $deductCoins = $this->DeductCoins($character_name, "gold", mconfig("clearskills_price"));
                                        if ($deductCoins) {
                                            $req_ok = true;
                                            $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearskills_price"), lang("currency_gold", true));
                                        } else {
                                            $req_ok = false;
                                        }
                                    } else {
                                        if (mconfig("clearskills_price_type") == "3") {
                                            $deductCoins = $this->DeductCoins($character_name, "silver", mconfig("clearskills_price"));
                                            if ($deductCoins) {
                                                $req_ok = true;
                                                $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearskills_price"), lang("currency_silver", true));
                                            } else {
                                                $req_ok = false;
                                            }
                                        } else {
                                            if (mconfig("clearskills_price_type") == "4") {
                                                $deductCoins = $this->DeductCashCoins($character_name, "WCoinC", mconfig("clearskills_price"));
                                                if ($deductCoins) {
                                                    $req_ok = true;
                                                    $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearskills_price"), lang("currency_wcoinc", true));
                                                } else {
                                                    $req_ok = false;
                                                }
                                            } else {
                                                if (mconfig("clearskills_price_type") == "5") {
                                                    $deductCoins = $this->DeductCashCoins($character_name, "GoblinPoint", mconfig("clearskills_price"));
                                                    if ($deductCoins) {
                                                        $req_ok = true;
                                                        $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearskills_price"), lang("currency_gp", true));
                                                    } else {
                                                        $req_ok = false;
                                                    }
                                                } else {
                                                    if (mconfig("clearskills_price_type") == "6") {
                                                        $deductZen = $this->DeductZEN($character_name, mconfig("clearskills_price"));
                                                        if ($deductZen) {
                                                            $req_ok = true;
                                                            $accountLog = sprintf(lang("resetcharacter_txt_6", true), mconfig("clearskills_price"), "" . lang("currency_zen", true) . "");
                                                        } else {
                                                            $req_ok = false;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            } else {
                                $req_ok = true;
                            }
                            if ($req_ok) {
                                $magicList = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT MagicList FROM Character WHERE AccountID = ? AND Name = ?), 2) AS magicList", [$username, $character_name]);
                                $magicList = $magicList["magicList"];
                                $newMagicList = $magicList;
                                $count = 0;
                                $magicListSize = 900;
                                $skillEmpty = "FF0000";
                                $skillSize = 6;
                                if (132 <= config("server_files_season", true)) {
                                    $skillSize = 10;
                                    $skillEmpty = "FF00000000";
                                    $magicListSize = 3700;
                                } else {
                                    if (130 <= config("server_files_season", true)) {
                                        $magicListSize = 4500;
                                        $skillEmpty = "FF00000000";
                                        $skillSize = 10;
                                    }
                                }
                                $i = 0;
                                while ($i < $magicListSize) {
                                    $skill = substr($magicList, $i, $i + $skillSize);
                                    $byte1 = substr($skill, 0, 2);
                                    $byte2 = substr($skill, 2, 2);
                                    $byte3 = substr($skill, 4, 2);
                                    $dec1 = base_convert($byte1, 16, 10);
                                    $dec3 = base_convert($byte3, 16, 10);
                                    $bin2 = base_convert($byte2, 16, 2);
                                    while (strlen($bin2) < 8) {
                                        $bin2 = "0" . $bin2;
                                    }
                                    $binx = "00000111";
                                    $and = $bin2 & $binx;
                                    $dec2 = base_convert($and, 2, 10);
                                    if (0 < $and) {
                                        $index = $dec1 * $dec2 + $dec3;
                                    } else {
                                        $index = $dec1;
                                    }
                                    if (!$this->is3rdSkillTreeSkill($index)) {
                                        $skillLevelBin = $bin2 >> 3;
                                        $newMagicList = substr_replace($newMagicList, $skillEmpty, $i, $skillSize);
                                    }
                                    $i += $skillSize;
                                }
                                $newMagicList = "0x" . $newMagicList;
                                $update = $dB->query("UPDATE Character SET MagicList = " . $newMagicList . " WHERE AccountID = '" . $username . "' AND Name = '" . $character_name . "'");
                                if ($update) {
                                    message("success", sprintf(lang("clearskills_txt_1", true), $character_name));
                                    $logDate = date("Y-m-d H:i:s", time());
                                    $common->accountLogs($username, "resetskills", sprintf(lang("clearskills_txt_2", true), $character_name, $accountLog), $logDate);
                                } else {
                                    message("error", lang("error_23", true));
                                }
                            } else {
                                message("error", lang("error_34", true));
                            }
                        } else {
                            message("error", lang("error_33", true));
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
    public function CharacterDualStatsSwitch($username, $character_name)
    {
        global $dB;
        global $dB2;
        global $common;
        global $custom;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::UsernameLength($username)) {
                return NULL;
            }
            if (!Validator::AlphaNumeric($username)) {
                return NULL;
            }
            if (!$common->accountOnline($username)) {
                $statsData = $this->CharacterDualStatsData($username, $character_name);
                $charData = $this->CharacterData($character_name);
                if ($charData["cLevel"] < mconfig("required_level")) {
                    message("error", lang("dualstats_txt_1", true));
                } else {
                    if (0 < $charData["LevelUpPoint"]) {
                        message("error", lang("dualstats_txt_2", true));
                    } else {
                        $equipCheck = true;
                        if (mconfig("equip_check")) {
                            $index = 0;
                            $inventory = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = ? AND Name = ?), 2) AS Inventory", [$username, $character_name]);
                            $inventory = $inventory["Inventory"];
                            if (132 <= config("server_files_season", true)) {
                                while ($index < 239) {
                                    $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                    if ($item != __ITEM_EMPTY__) {
                                        $equipCheck = false;
                                    }
                                    $index++;
                                    if ($index == 12) {
                                        $index = 236;
                                    }
                                }
                            } else {
                                while ($index < 237) {
                                    $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                    if ($item != __ITEM_EMPTY__) {
                                        $equipCheck = false;
                                    }
                                    $index++;
                                    if ($index == 12) {
                                        $index = 236;
                                    }
                                }
                            }
                        }
                        if ($equipCheck) {
                            $totalStatsDual = $statsData["Strength"] + $statsData["Dexterity"] + $statsData["Vitality"] + $statsData["Energy"];
                            $totalStatsChar = $charData["Strength"] + $charData["Dexterity"] + $charData["Vitality"] + $charData["Energy"];
                            if (in_array($charData["Class"], $custom["class_filter"]["lord"])) {
                                $totalStatsDual += $statsData["Leadership"];
                                $totalStatsChar += $charData["Leadership"];
                            } else {
                                $statsData["Leadership"] = 0;
                                $charData["Leadership"] = 0;
                            }
                            $lvlup = $totalStatsChar - $totalStatsDual;
                            if ($lvlup < 0) {
                                message("error", lang("dualstats_txt_3", true));
                            } else {
                                if ($statsData["active"] == "0") {
                                    $active = 1;
                                } else {
                                    if ($statsData["active"] == "1") {
                                        $active = 0;
                                    }
                                }
                                if (mconfig("store_equip")) {
                                    if ($statsData["inv_slot_0"] == NULL) {
                                        $db_slot0 = __ITEM_EMPTY__;
                                    } else {
                                        $db_slot0 = $statsData["inv_slot_0"];
                                    }
                                    if ($statsData["inv_slot_1"] == NULL) {
                                        $db_slot1 = __ITEM_EMPTY__;
                                    } else {
                                        $db_slot1 = $statsData["inv_slot_1"];
                                    }
                                    if ($statsData["inv_slot_2"] == NULL) {
                                        $db_slot2 = __ITEM_EMPTY__;
                                    } else {
                                        $db_slot2 = $statsData["inv_slot_2"];
                                    }
                                    if ($statsData["inv_slot_3"] == NULL) {
                                        $db_slot3 = __ITEM_EMPTY__;
                                    } else {
                                        $db_slot3 = $statsData["inv_slot_3"];
                                    }
                                    if ($statsData["inv_slot_4"] == NULL) {
                                        $db_slot4 = __ITEM_EMPTY__;
                                    } else {
                                        $db_slot4 = $statsData["inv_slot_4"];
                                    }
                                    if ($statsData["inv_slot_5"] == NULL) {
                                        $db_slot5 = __ITEM_EMPTY__;
                                    } else {
                                        $db_slot5 = $statsData["inv_slot_5"];
                                    }
                                    if ($statsData["inv_slot_6"] == NULL) {
                                        $db_slot6 = __ITEM_EMPTY__;
                                    } else {
                                        $db_slot6 = $statsData["inv_slot_6"];
                                    }
                                    if ($statsData["inv_slot_7"] == NULL) {
                                        $db_slot7 = __ITEM_EMPTY__;
                                    } else {
                                        $db_slot7 = $statsData["inv_slot_7"];
                                    }
                                    if ($statsData["inv_slot_8"] == NULL) {
                                        $db_slot8 = __ITEM_EMPTY__;
                                    } else {
                                        $db_slot8 = $statsData["inv_slot_8"];
                                    }
                                    if ($statsData["inv_slot_9"] == NULL) {
                                        $db_slot9 = __ITEM_EMPTY__;
                                    } else {
                                        $db_slot9 = $statsData["inv_slot_9"];
                                    }
                                    if ($statsData["inv_slot_10"] == NULL) {
                                        $db_slot10 = __ITEM_EMPTY__;
                                    } else {
                                        $db_slot10 = $statsData["inv_slot_10"];
                                    }
                                    if ($statsData["inv_slot_11"] == NULL) {
                                        $db_slot11 = __ITEM_EMPTY__;
                                    } else {
                                        $db_slot11 = $statsData["inv_slot_11"];
                                    }
                                    if ($statsData["inv_slot_236"] == NULL) {
                                        $db_slot236 = __ITEM_EMPTY__;
                                    } else {
                                        $db_slot236 = $statsData["inv_slot_236"];
                                    }
                                    if (132 <= config("server_files_season", true)) {
                                        if ($statsData["inv_slot_237"] == NULL) {
                                            $db_slot237 = __ITEM_EMPTY__;
                                        } else {
                                            $db_slot237 = $statsData["inv_slot_237"];
                                        }
                                        if ($statsData["inv_slot_238"] == NULL) {
                                            $db_slot238 = __ITEM_EMPTY__;
                                        } else {
                                            $db_slot238 = $statsData["inv_slot_238"];
                                        }
                                        $whileLoop = 239;
                                    } else {
                                        $whileLoop = 237;
                                    }
                                    $inventory = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = ? AND Name = ?), 2) AS Inventory", [$username, $character_name]);
                                    $inventory = $inventory["Inventory"];
                                    $inv_length = strlen($inventory);
                                    $index = 0;
                                    while ($index < $whileLoop) {
                                        if ($index == 0) {
                                            $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                            $inv_slot0 = $item;
                                            $inventory = substr_replace($inventory, $db_slot0, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                        } else {
                                            if ($index == 1) {
                                                $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                $inv_slot1 = $item;
                                                $inventory = substr_replace($inventory, $db_slot1, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                            } else {
                                                if ($index == 2) {
                                                    $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                    $inv_slot2 = $item;
                                                    $inventory = substr_replace($inventory, $db_slot2, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                } else {
                                                    if ($index == 3) {
                                                        $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                        $inv_slot3 = $item;
                                                        $inventory = substr_replace($inventory, $db_slot3, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                    } else {
                                                        if ($index == 4) {
                                                            $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                            $inv_slot4 = $item;
                                                            $inventory = substr_replace($inventory, $db_slot4, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                        } else {
                                                            if ($index == 5) {
                                                                $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                                $inv_slot5 = $item;
                                                                $inventory = substr_replace($inventory, $db_slot5, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                            } else {
                                                                if ($index == 6) {
                                                                    $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                                    $inv_slot6 = $item;
                                                                    $inventory = substr_replace($inventory, $db_slot6, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                } else {
                                                                    if ($index == 7) {
                                                                        $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                                        $inv_slot7 = $item;
                                                                        $inventory = substr_replace($inventory, $db_slot7, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                    } else {
                                                                        if ($index == 8) {
                                                                            $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                                            $inv_slot8 = $item;
                                                                            $inventory = substr_replace($inventory, $db_slot8, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                        } else {
                                                                            if ($index == 9) {
                                                                                $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                                                $inv_slot9 = $item;
                                                                                $inventory = substr_replace($inventory, $db_slot9, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                            } else {
                                                                                if ($index == 10) {
                                                                                    $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                                                    $inv_slot10 = $item;
                                                                                    $inventory = substr_replace($inventory, $db_slot10, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                                } else {
                                                                                    if ($index == 11) {
                                                                                        $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                                                        $inv_slot11 = $item;
                                                                                        $inventory = substr_replace($inventory, $db_slot11, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                                    } else {
                                                                                        if ($index == 236) {
                                                                                            if (15168 <= $inv_length) {
                                                                                                $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                                                                $inv_slot236 = $item;
                                                                                                $inventory = substr_replace($inventory, $db_slot236, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                                            }
                                                                                        } else {
                                                                                            if ($index == 237) {
                                                                                                if (15296 <= $inv_length) {
                                                                                                    $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                                                                    $inv_slot237 = $item;
                                                                                                    $inventory = substr_replace($inventory, $db_slot237, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
                                                                                                }
                                                                                            } else {
                                                                                                if ($index == 238 && 15296 <= $inv_length) {
                                                                                                    $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                                                                                    $inv_slot238 = $item;
                                                                                                    $inventory = substr_replace($inventory, $db_slot238, $index * __ITEM_LENGTH__, __ITEM_LENGTH__);
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
                                        }
                                        $index++;
                                    }
                                    $inventory = "0x" . $inventory;
                                    $query = $dB->query("UPDATE Character SET Inventory = " . $inventory . " WHERE AccountID = '" . $username . "' AND Name = '" . $character_name . "'");
                                    if (132 <= config("server_files_season", true)) {
                                        $query2 = $dB->query("UPDATE IMPERIAMUCMS_DUAL_STATS SET inv_slot_0 = ?, inv_slot_1 = ?, inv_slot_2 = ?, inv_slot_3 = ?, inv_slot_4 = ?, inv_slot_5 = ?, inv_slot_6 = ?,\r\n                                                          inv_slot_7 = ?, inv_slot_8 = ?, inv_slot_9 = ?, inv_slot_10 = ?, inv_slot_11 = ?, inv_slot_236 = ?, inv_slot_237 = ?, inv_slot_238 = ? WHERE AccountID = ? AND Name = ?", [$inv_slot0, $inv_slot1, $inv_slot2, $inv_slot3, $inv_slot4, $inv_slot5, $inv_slot6, $inv_slot7, $inv_slot8, $inv_slot9, $inv_slot10, $inv_slot11, $inv_slot236, $inv_slot237, $inv_slot238, $username, $character_name]);
                                    } else {
                                        $query2 = $dB->query("UPDATE IMPERIAMUCMS_DUAL_STATS SET inv_slot_0 = ?, inv_slot_1 = ?, inv_slot_2 = ?, inv_slot_3 = ?, inv_slot_4 = ?, inv_slot_5 = ?, inv_slot_6 = ?,\r\n                                                          inv_slot_7 = ?, inv_slot_8 = ?, inv_slot_9 = ?, inv_slot_10 = ?, inv_slot_11 = ?, inv_slot_236 = ? WHERE AccountID = ? AND Name = ?", [$inv_slot0, $inv_slot1, $inv_slot2, $inv_slot3, $inv_slot4, $inv_slot5, $inv_slot6, $inv_slot7, $inv_slot8, $inv_slot9, $inv_slot10, $inv_slot11, $inv_slot236, $username, $character_name]);
                                    }
                                }
                                $update1 = $dB->query("UPDATE Character SET LevelUpPoint = ?, Strength = ?, Dexterity = ?, Vitality = ?, Energy = ?, Leadership = ? WHERE AccountID = ? AND Name = ?", [$lvlup, $statsData["Strength"], $statsData["Dexterity"], $statsData["Vitality"], $statsData["Energy"], $statsData["Leadership"], $username, $character_name]);
                                $update2 = $dB->query("UPDATE IMPERIAMUCMS_DUAL_STATS SET Strength = ?, Dexterity = ?, Vitality = ?, Energy = ?, Leadership = ?, active = ? WHERE AccountID = ? AND Name = ?", [$charData["Strength"], $charData["Dexterity"], $charData["Vitality"], $charData["Energy"], $charData["Leadership"], $active, $username, $character_name]);
                                if ($update1 && $update2) {
                                    message("success", lang("dualstats_txt_4", true));
                                } else {
                                    message("error", lang("error_23", true));
                                }
                            }
                        } else {
                            message("error", lang("dualstats_txt_5", true));
                        }
                    }
                }
                $Account->banAccount($username);
            } else {
                message("error", lang("error_14", true));
            }
        } else {
            return NULL;
        }
    }
    public function CharacterDualStatsData($username, $character_name)
    {
        global $dB;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_23", true));
                } else {
                    $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_DUAL_STATS WHERE Name = ?", [$character_name]);
                    if (is_array($result)) {
                        return $result;
                    }
                    $empty = __ITEM_EMPTY__;
                    if (132 <= config("server_files_season", true)) {
                        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_DUAL_STATS(AccountID,Name,Strength,Dexterity,Vitality,Energy,Leadership,active,inv_slot_0,inv_slot_1,inv_slot_2,inv_slot_3,inv_slot_4,inv_slot_5,inv_slot_6,inv_slot_7,inv_slot_8,inv_slot_9,inv_slot_10,inv_slot_11,inv_slot_236,inv_slot_237,inv_slot_238)\r\n                                      VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$username, $character_name, 25, 25, 25, 25, 25, 0, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty]);
                    } else {
                        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_DUAL_STATS(AccountID,Name,Strength,Dexterity,Vitality,Energy,Leadership,active,inv_slot_0,inv_slot_1,inv_slot_2,inv_slot_3,inv_slot_4,inv_slot_5,inv_slot_6,inv_slot_7,inv_slot_8,inv_slot_9,inv_slot_10,inv_slot_11,inv_slot_236)\r\n                                      VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$username, $character_name, 25, 25, 25, 25, 25, 0, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty]);
                    }
                    $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_DUAL_STATS WHERE Name = ?", [$character_name]);
                    return $result;
                }
            }
        } else {
            return NULL;
        }
    }
    public function CharacterDualStatsUnlock($username, $character_name)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_23", true));
                } else {
                    $checkDualStats = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_DUAL_STATS WHERE Name = ?", [$character_name]);
                    if ($checkDualStats["AccountID"] == NULL) {
                        $coins_check = false;
                        try {
                            $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                            $creditSystem->setConfigId(mconfig("credit_config"));
                            $configSettings = $creditSystem->showConfigs(true);
                            switch ($configSettings["config_user_col_id"]) {
                                case "userid":
                                    $creditSystem->setIdentifier($_SESSION["userid"]);
                                    break;
                                case "username":
                                    $creditSystem->setIdentifier($_SESSION["username"]);
                                    break;
                                case "character":
                                    $creditSystem->setIdentifier($character_name);
                                    $creditSystem->subtractCredits(mconfig("price"));
                                    $coins_check = true;
                                    break;
                                default:
                                    throw new Exception("Invalid identifier (credit system).");
                            }
                        } catch (Exception $ex) {
                            if ($coins_check) {
                                $empty = __ITEM_EMPTY__;
                                $insert = $dB->query("INSERT INTO IMPERIAMUCMS_DUAL_STATS(AccountID,Name,Strength,Dexterity,Vitality,Energy,Leadership,active,inv_slot_0,inv_slot_1,inv_slot_2,inv_slot_3,inv_slot_4,inv_slot_5,inv_slot_6,inv_slot_7,inv_slot_8,inv_slot_9,inv_slot_10,inv_slot_11,inv_slot_236)\r\n                                      VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$username, $character_name, 25, 25, 25, 25, 25, 0, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty]);
                                if ($insert) {
                                    message("success", sprintf(lang("dualstats_txt_6", true), $character_name));
                                    return true;
                                }
                                message("error", lang("error_23", true));
                            } else {
                                message("error", lang("error_23", true));
                            }
                        }
                    } else {
                        message("error", lang("dualstats_txt_7", true));
                    }
                }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function CharacterDualSkillTreeUnlock($username, $character_name)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_23", true));
                } else {
                    $checkDualSkillTree = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_DUAL_SKILLTREE WHERE Name = ?", [$character_name]);
                    if ($checkDualSkillTree["AccountID"] == NULL) {
                        $charData = $this->CharacterData($character_name);
                        if ($charData["Class"] == "2" || $charData["Class"] == "3" || $charData["Class"] == "18" || $charData["Class"] == "19" || $charData["Class"] == "34" || $charData["Class"] == "35" || $charData["Class"] == "49" || $charData["Class"] == "50" || $charData["Class"] == "65" || $charData["Class"] == "66" || $charData["Class"] == "82" || $charData["Class"] == "83" || $charData["Class"] == "97" || $charData["Class"] == "98" || $charData["Class"] == "114" || $charData["Class"] == "7" || $charData["Class"] == "23" || $charData["Class"] == "39" || $charData["Class"] == "54" || $charData["Class"] == "70" || $charData["Class"] == "87" || $charData["Class"] == "102" || $charData["Class"] == "118" || $charData["Class"] == "131" || $charData["Class"] == "135" || $charData["Class"] == "147" || $charData["Class"] == "151") {
                            $coins_check = false;
                            try {
                                $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                                $creditSystem->setConfigId(mconfig("credit_config"));
                                $configSettings = $creditSystem->showConfigs(true);
                                switch ($configSettings["config_user_col_id"]) {
                                    case "userid":
                                        $creditSystem->setIdentifier($_SESSION["userid"]);
                                        break;
                                    case "username":
                                        $creditSystem->setIdentifier($_SESSION["username"]);
                                        break;
                                    case "character":
                                        $creditSystem->setIdentifier($character_name);
                                        $creditSystem->subtractCredits(mconfig("price"));
                                        $coins_check = true;
                                        break;
                                    default:
                                        throw new Exception("Invalid identifier (credit system).");
                                }
                            } catch (Exception $ex) {
                                if ($coins_check) {
                                    $insert = $dB->query("INSERT INTO IMPERIAMUCMS_DUAL_SKILLTREE(AccountID,Name,active,MagicList) VALUES(?,?,?,?)", [$username, $character_name, 0, NULL]);
                                    if ($insert) {
                                        message("success", sprintf(lang("dualst_txt_1", true), $character_name));
                                        return true;
                                    }
                                    message("error", lang("error_23", true));
                                } else {
                                    message("error", lang("error_23", true));
                                }
                            }
                        } else {
                            message("error", lang("dualst_txt_2", true));
                        }
                    } else {
                        message("error", lang("dualst_txt_3", true));
                    }
                }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function CharacterDualSkillTreeSwitch($username, $character_name)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($username) && check_value($character_name)) {
            if (!Validator::UsernameLength($username)) {
                return NULL;
            }
            if (!Validator::AlphaNumeric($username)) {
                return NULL;
            }
            if ($this->CharacterExists($character_name) && $this->CharacterBelongsToAccount($character_name, $username)) {
                if (!$common->accountOnline($username)) {
                    $charData = $this->CharacterData($character_name);
                    if ($charData["Class"] == "2" || $charData["Class"] == "3" || $charData["Class"] == "18" || $charData["Class"] == "19" || $charData["Class"] == "34" || $charData["Class"] == "35" || $charData["Class"] == "49" || $charData["Class"] == "50" || $charData["Class"] == "65" || $charData["Class"] == "66" || $charData["Class"] == "82" || $charData["Class"] == "83" || $charData["Class"] == "97" || $charData["Class"] == "98" || $charData["Class"] == "114" || $charData["Class"] == "7" || $charData["Class"] == "23" || $charData["Class"] == "39" || $charData["Class"] == "54" || $charData["Class"] == "70" || $charData["Class"] == "87" || $charData["Class"] == "102" || $charData["Class"] == "118" || $charData["Class"] == "131" || $charData["Class"] == "135" || $charData["Class"] == "147" || $charData["Class"] == "151") {
                        if ($charData["cLevel"] < mconfig("required_level")) {
                            message("error", lang("dualst_txt_4", true));
                        } else {
                            if (0 < $charData["mlPoint"]) {
                                message("error", lang("dualst_txt_5", true));
                            } else {
                                $magicList = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT MagicList FROM Character WHERE AccountID = ? AND Name = ?), 2) AS magicList", [$username, $character_name]);
                                $dualSkillTreeMagicList = $dB->query_fetch_single("SELECT MagicList FROM IMPERIAMUCMS_DUAL_SKILLTREE WHERE AccountID = ? AND Name = ?", [$username, $character_name]);
                                $magicList = $magicList["magicList"];
                                $dualSkillTreeMagicList = $dualSkillTreeMagicList["MagicList"];
                                $newMagicList = $magicList;
                                $dualMagicList = "";
                                $countChar = 0;
                                $countDB = 0;
                                $magicListSize = 900;
                                $skillSize = 6;
                                $skillEmpty = "FF0000";
                                if (132 <= config("server_files_season", true)) {
                                    $magicListSize = 3700;
                                    $skillSize = 10;
                                    $skillEmpty = "FF00000000";
                                } else {
                                    if (130 <= config("server_files_season", true)) {
                                        $magicListSize = 4500;
                                        $skillSize = 10;
                                        $skillEmpty = "FF00000000";
                                    }
                                }
                                $i = 0;
                                while ($i < $magicListSize) {
                                    $skill = NULL;
                                    $skill = substr($magicList, $i, $skillSize);
                                    $byte1 = substr($skill, 0, 2);
                                    $byte2 = substr($skill, 2, 2);
                                    $byte3 = substr($skill, 4, 2);
                                    $dec1 = base_convert($byte1, 16, 10);
                                    $dec3 = base_convert($byte3, 16, 10);
                                    $bin2 = base_convert($byte2, 16, 2);
                                    while (strlen($bin2) < 8) {
                                        $bin2 = "0" . $bin2;
                                    }
                                    $binx = "00000111";
                                    $and = $bin2 & $binx;
                                    $dec2 = base_convert($and, 2, 10);
                                    if (0 < $and) {
                                        $index = $dec1 * $dec2 + $dec3;
                                    } else {
                                        $index = $dec1;
                                    }
                                    if ($this->is3rdSkillTreeSkill($index)) {
                                        $dec22 = base_convert($byte2, 16, 10);
                                        $dec22 = floor($dec22 / 2);
                                        $dec22 = floor($dec22 / 2);
                                        $dec22 = floor($dec22 / 2);
                                        $skillLevel = $dec22;
                                        $dualMagicList .= $skill;
                                        $newMagicList = substr_replace($newMagicList, $skillEmpty, $i, $skillSize);
                                        $countChar = $countChar + $skillLevel * 1;
                                    }
                                    $i = $i + $skillSize;
                                }
                                $i = 0;
                                $j = 0;
                                $countXX = 0;
                                $countYY = 0;
                                while ($i < $magicListSize) {
                                    $skillDB = NULL;
                                    $skillDB = substr($dualSkillTreeMagicList, $i, $skillSize);
                                    if ($skillDB != NULL && $skillDB != $skillEmpty) {
                                        $countYY++;
                                        $byte1 = substr($skillDB, 0, 2);
                                        $byte2 = substr($skillDB, 2, 2);
                                        $byte3 = substr($skillDB, 4, 2);
                                        $dec22 = base_convert($byte2, 16, 10);
                                        $dec22 = floor($dec22 / 2);
                                        $dec22 = floor($dec22 / 2);
                                        $dec22 = floor($dec22 / 2);
                                        $skillLevel = $dec22;
                                        $countDB = $countDB + $skillLevel * 1;
                                        while ($j < $magicListSize) {
                                            $skillChar = NULL;
                                            $skillChar = substr($newMagicList, $j, $skillSize);
                                            if ($skillChar == $skillEmpty) {
                                                $newMagicList = substr_replace($newMagicList, $skillDB, $j, $skillSize);
                                                $countXX++;
                                            } else {
                                                $j = $j + $skillSize;
                                            }
                                        }
                                    } else {
                                        $i = $magicListSize;
                                    }
                                    $i = $i + $skillSize;
                                }
                                while (strlen($newMagicList) < $magicListSize) {
                                    $newMagicList .= $skillEmpty;
                                }
                                $newMagicList = "0x" . $newMagicList;
                                if ($countDB <= $countChar) {
                                    $addPoints = $countChar - $countDB;
                                    $update = $dB->query("UPDATE Character SET MagicList = " . $newMagicList . ", mlPoint = " . $addPoints . " WHERE AccountID = '" . $username . "' AND Name = '" . $character_name . "'");
                                    $update2 = $dB->query("UPDATE IMPERIAMUCMS_DUAL_SKILLTREE SET MagicList = ? WHERE AccountID = ? AND Name = ?", [$dualMagicList, $username, $character_name]);
                                    if ($update && $update2) {
                                        message("success", lang("dualst_txt_6", true));
                                        return true;
                                    }
                                    message("error", lang("error_23", true));
                                } else {
                                    message("error", lang("dualst_txt_7", true));
                                }
                            }
                        }
                    } else {
                        message("error", lang("dualst_txt_8", true));
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
    }
    public function transferCharacter($username, $receiver, $character_name)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($username) && check_value($receiver) && check_value($character_name)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if (!$common->userExists($receiver)) {
                message("error", lang("transferchar_txt_1", true));
                return NULL;
            }
            if (!$common->accountOnline($username) && !$common->accountOnline($receiver)) {
                $guild_check = $dB->query_fetch_single("SELECT * FROM GuildMember WHERE Name = ?", [$character_name]);
                if ($guild_check != NULL) {
                    message("error", lang("transferchar_txt_2", true));
                } else {
                    $receiver_chars = $dB->query_fetch_single("SELECT COUNT(*) as count FROM Character WHERE AccountID = ?", [$receiver]);
                    $receiver_chars = $receiver_chars["count"];
                    $maxSlots = 5;
                    if (131 <= config("server_files_season", true)) {
                        $maxSlots = 8;
                    } else {
                        if (150 <= config("server_files_season", true)) {
                            $maxSlots = 10;
                        }
                    }
                    if ($maxSlots <= $receiver_chars) {
                        message("error", lang("transferchar_txt_3", true));
                    } else {
                        $coins_check = false;
                        if (0 < mconfig("tax")) {
                            try {
                                $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                                $creditSystem->setConfigId(mconfig("tax_type"));
                                $configSettings = $creditSystem->showConfigs(true);
                                switch ($configSettings["config_user_col_id"]) {
                                    case "userid":
                                        $creditSystem->setIdentifier($_SESSION["userid"]);
                                        break;
                                    case "username":
                                        $creditSystem->setIdentifier($_SESSION["username"]);
                                        break;
                                    case "character":
                                        $creditSystem->setIdentifier($character_name);
                                        $creditSystem->subtractCredits(mconfig("tax"));
                                        $coins_check = true;
                                        break;
                                    default:
                                        throw new Exception("Invalid identifier (credit system).");
                                }
                            } catch (Exception $ex) {
                                message("error", $ex->getMessage());
                            }
                        } else {
                            $coins_check = true;
                        }
                        if ($coins_check) {
                            $checkAC = $dB->query_fetch_single("SELECT Id FROM AccountCharacter WHERE Id = ?", [$receiver]);
                            if ($checkAC["Id"] == NULL) {
                                $dB->query("INSERT INTO AccountCharacter(Id,GameID1,GameID2,GameID3,GameID4,GameID5,GameIDC) VALUES(?,?,?,?,?,?,?)", [$receiver, NULL, NULL, NULL, NULL, NULL, NULL]);
                            }
                            $update = $dB->query("UPDATE Character SET AccountID = ? WHERE AccountID = ? AND Name = ?", [$receiver, $username, $character_name]);
                            $update2 = $dB->query("UPDATE AccountCharacter SET GameID1 = NULL WHERE Id = ? AND GameID1 = ?", [$username, $character_name]);
                            $update2 = $dB->query("UPDATE AccountCharacter SET GameID2 = NULL WHERE Id = ? AND GameID2 = ?", [$username, $character_name]);
                            $update2 = $dB->query("UPDATE AccountCharacter SET GameID3 = NULL WHERE Id = ? AND GameID3 = ?", [$username, $character_name]);
                            $update2 = $dB->query("UPDATE AccountCharacter SET GameID4 = NULL WHERE Id = ? AND GameID4 = ?", [$username, $character_name]);
                            $update2 = $dB->query("UPDATE AccountCharacter SET GameID5 = NULL WHERE Id = ? AND GameID5 = ?", [$username, $character_name]);
                            $update2 = $dB->query("UPDATE AccountCharacter SET GameIDC = NULL WHERE Id = ? AND GameIDC = ?", [$username, $character_name]);
                            if (131 <= config("server_files_season", true)) {
                                $update2 = $dB->query("UPDATE AccountCharacter SET GameID6 = NULL WHERE Id = ? AND GameID6 = ?", [$username, $character_name]);
                                $update2 = $dB->query("UPDATE AccountCharacter SET GameID7 = NULL WHERE Id = ? AND GameID7 = ?", [$username, $character_name]);
                                $update2 = $dB->query("UPDATE AccountCharacter SET GameID9 = NULL WHERE Id = ? AND GameID8 = ?", [$username, $character_name]);
                            } else {
                                if (150 <= config("server_files_season", true)) {
                                    $update2 = $dB->query("UPDATE AccountCharacter SET GameID9 = NULL WHERE Id = ? AND GameID9 = ?", [$username, $character_name]);
                                    $update2 = $dB->query("UPDATE AccountCharacter SET GameID10 = NULL WHERE Id = ? AND GameID10 = ?", [$username, $character_name]);
                                }
                            }
                            $gameid_check = $dB->query_fetch_single("SELECT * FROM AccountCharacter WHERE Id = ?", [$receiver]);
                            if ($gameid_check["GameID1"] == NULL) {
                                $update3 = $dB->query("UPDATE AccountCharacter SET GameID1 = ? WHERE Id = ?", [$character_name, $receiver]);
                            } else {
                                if ($gameid_check["GameID2"] == NULL) {
                                    $update3 = $dB->query("UPDATE AccountCharacter SET GameID2 = ? WHERE Id = ?", [$character_name, $receiver]);
                                } else {
                                    if ($gameid_check["GameID3"] == NULL) {
                                        $update3 = $dB->query("UPDATE AccountCharacter SET GameID3 = ? WHERE Id = ?", [$character_name, $receiver]);
                                    } else {
                                        if ($gameid_check["GameID4"] == NULL) {
                                            $update3 = $dB->query("UPDATE AccountCharacter SET GameID4 = ? WHERE Id = ?", [$character_name, $receiver]);
                                        } else {
                                            if ($gameid_check["GameID5"] == NULL) {
                                                $update3 = $dB->query("UPDATE AccountCharacter SET GameID5 = ? WHERE Id = ?", [$character_name, $receiver]);
                                            } else {
                                                if ($gameid_check["GameID6"] == NULL && 131 <= config("server_files_season", true)) {
                                                    $update3 = $dB->query("UPDATE AccountCharacter SET GameID6 = ? WHERE Id = ?", [$character_name, $receiver]);
                                                } else {
                                                    if ($gameid_check["GameID7"] == NULL && 131 <= config("server_files_season", true)) {
                                                        $update3 = $dB->query("UPDATE AccountCharacter SET GameID7 = ? WHERE Id = ?", [$character_name, $receiver]);
                                                    } else {
                                                        if ($gameid_check["GameID8"] == NULL && 131 <= config("server_files_season", true)) {
                                                            $update3 = $dB->query("UPDATE AccountCharacter SET GameID8 = ? WHERE Id = ?", [$character_name, $receiver]);
                                                        } else {
                                                            if ($gameid_check["GameID9"] == NULL && 150 <= config("server_files_season", true)) {
                                                                $update3 = $dB->query("UPDATE AccountCharacter SET GameID9 = ? WHERE Id = ?", [$character_name, $receiver]);
                                                            } else {
                                                                if ($gameid_check["GameID10"] == NULL && 150 <= config("server_files_season", true)) {
                                                                    $update3 = $dB->query("UPDATE AccountCharacter SET GameID10 = ? WHERE Id = ?", [$character_name, $receiver]);
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
                            $dB->query("DELETE FROM IMPERIAMUCMS_ACHIEVEMENTS WHERE Name = ?", [$character_name]);
                            $dB->query("DELETE FROM IMPERIAMUCMS_ACHIEVEMENTS_RANKING WHERE Name = ?", [$character_name]);
                            $dB->query("DELETE FROM IMPERIAMUCMS_ACHIEVEMENTS_UNLOCK WHERE Name = ?", [$character_name]);
                            $dB->query("DELETE FROM IMPERIAMUCMS_DUAL_SKILLTREE WHERE Name = ?", [$character_name]);
                            $dB->query("DELETE FROM IMPERIAMUCMS_DUAL_STATS WHERE Name = ?", [$character_name]);
                            if ($update && $update2 && $update3) {
                                message("success", sprintf(lang("transferchar_txt_4", true), $character_name, $receiver));
                                $logDate = date("Y-m-d H:i:s", time());
                                $common->accountLogs($username, "transfercharacter", sprintf(lang("transferchar_txt_5", true), $character_name, $receiver), $logDate);
                                $dB->query("INSERT INTO IMPERIAMUCMS_TRANSFER_CHAR_LOGS (OldAccountID, NewAccountID, Name, price, price_type, date) VALUES (?, ?, ?, ?, ?, ?)", [$username, $receiver, $character_name, mconfig("tax"), mconfig("tax_type"), date("Y-m-d H:i:s", time())]);
                            } else {
                                message("error", lang("error_23", true));
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
    }
    public function getCharacterFlag($character_name)
    {
        global $dB;
        global $dB2;
        global $custom;
        $accountid = $dB->query_fetch_single("SELECT AccountID FROM Character WHERE Name = ?", [$character_name]);
        $accountid = $accountid["AccountID"];
        if (config("SQL_USE_2_DB", true)) {
            $country = $dB2->query_fetch_single("SELECT Country FROM MEMB_INFO WHERE memb___id = ?", [$accountid]);
        } else {
            $country = $dB->query_fetch_single("SELECT Country FROM MEMB_INFO WHERE memb___id = ?", [$accountid]);
        }
        return $country["Country"];
    }
    public function renameCharacter($username, $new_name, $old_name)
    {
        global $dB;
        global $dB2;
        global $common;
        global $config;
        if (check_value($username) && check_value($new_name) && check_value($old_name)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if ($this->CharacterExists($old_name) && $this->CharacterBelongsToAccount($old_name, $username)) {
                if (!$common->accountOnline($username)) {
                    if (mconfig("allow_special_chars")) {
                        $regex = "0-9a-zA-Z_\\[\\]\\(\\)\\{\\}!~^@#\$?=-\\\\+\\/\\*\\|";
                    } else {
                        $regex = "0-9a-zA-Z";
                    }
                    if (preg_match("/^[" . $regex . "]{4,10}\$/i", $new_name) || mconfig("disable_regex")) {
                        if (4 <= strlen($new_name) && strlen($new_name) <= 10) {
                            $guild = $dB->query_fetch_single("SELECT G_Name FROM GuildMember WHERE Name = ?", [$old_name]);
                            if ($guild["G_Name"] == NULL) {
                                $checkName = $dB->query_fetch_single("SELECT Name FROM Character WHERE Name = ?", [$new_name]);
                                if ($checkName["Name"] == NULL) {
                                    $coins_check = false;
                                    if (0 < mconfig("price")) {
                                        try {
                                            $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                                            $creditSystem->setConfigId(mconfig("credit_config"));
                                            $configSettings = $creditSystem->showConfigs(true);
                                            switch ($configSettings["config_user_col_id"]) {
                                                case "userid":
                                                    $creditSystem->setIdentifier($_SESSION["userid"]);
                                                    break;
                                                case "username":
                                                    $creditSystem->setIdentifier($_SESSION["username"]);
                                                    break;
                                                case "character":
                                                    $creditSystem->setIdentifier($old_name);
                                                    $creditSystem->subtractCredits(mconfig("price"));
                                                    $coins_check = true;
                                                    break;
                                                default:
                                                    throw new Exception("Invalid identifier (credit system).");
                                            }
                                        } catch (Exception $ex) {
                                            message("error", $ex->getMessage());
                                        }
                                    } else {
                                        $coins_check = true;
                                    }
                                    if ($coins_check) {
                                        $dB->query("UPDATE AccountCharacter SET GameID1 = ? WHERE GameID1 = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE AccountCharacter SET GameID2 = ? WHERE GameID2 = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE AccountCharacter SET GameID3 = ? WHERE GameID3 = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE AccountCharacter SET GameID4 = ? WHERE GameID4 = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE AccountCharacter SET GameID5 = ? WHERE GameID5 = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE AccountCharacter SET GameIDC = ? WHERE GameIDC = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE C_Monster_KillCount SET name = ? WHERE name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE C_PlayerKiller_Info SET Victim = ? WHERE Victim = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE C_PlayerKiller_Info SET Killer = ? WHERE Killer = ?", [$new_name, $old_name]);
                                        if (config("server_files_season", true) <= 60) {
                                            $dB->query("UPDATE IGC_ChaosCastleFinal_Ranking SET mName = ? WHERE mName = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_ChaosCastleFinal_Scores SET mName = ? WHERE mName = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_PeriodExpiredItemInfo SET CharacterName = ? WHERE CharacterName = ?", [$new_name, $old_name]);
                                        }
                                        if (120 <= config("server_files_season", true) && config("server_files_season", true) < 130) {
                                            $dB->query("UPDATE IGC_CancelItemSale SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_EventEntryCount SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_EvoMonRanking SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_HuntingLog SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_MazeUserData SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_MuunInfo SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        }
                                        if (config("server_files_season", true) < 130) {
                                            $dB->query("UPDATE PetWarehouse SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE T_PentagramInfo SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        }
                                        if (120 <= config("server_files_season", true)) {
                                            $dB->query("UPDATE IGC_BlockChat SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_BlockChat SET BlockedName = ? WHERE BlockedName = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_GremoryCase SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_PentagramInfo SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE T_BombGameScore SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        }
                                        if (130 <= config("server_files_season", true)) {
                                            $dB->query("UPDATE IGC_ClassQuest_MonsterKill SET CharacterName = ? WHERE CharacterName = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_EventMapEnterLimit SET CharacterName = ? WHERE CharacterName = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_EvolutionMonster SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_FavouriteWarpData SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_HuntingRecord SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_HuntingRecordOption SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_LabyrinthClearLog SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_LabyrinthInfo SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_LabyrinthMissionInfo SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_Muun_ConditionInfo SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_Muun_Inventory SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_Muun_Period SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_RestoreItem_Inventory SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE T_GUIDE_QUEST_INFO SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE AccountCharacter SET GameID6 = ? WHERE GameID1 = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE AccountCharacter SET GameID7 = ? WHERE GameID1 = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE AccountCharacter SET GameID8 = ? WHERE GameID1 = ?", [$new_name, $old_name]);
                                        }
                                        if (140 <= config("server_files_season", true)) {
                                            $dB->query("UPDATE IGC_MixLostItemInfo SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE IGC_HuntingRecord SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        }
                                        if (150 <= config("server_files_season", true)) {
                                            $dB->query("UPDATE AccountCharacter SET GameID9 = ? WHERE GameID1 = ?", [$new_name, $old_name]);
                                            $dB->query("UPDATE AccountCharacter SET GameID10 = ? WHERE GameID1 = ?", [$new_name, $old_name]);
                                        }
                                        $dB->query("UPDATE IGC_ARCA_BATTLE_MEMBER_JOIN_INFO SET CharName = ? WHERE CharName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IGC_FriendChat_BannedCharacters SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IGC_FriendChat_MessageLog SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IGC_FriendChat_MessageLog SET FriendName = ? WHERE FriendName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IGC_Gens SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IGC_GensAbuse SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IGC_GensAbuse SET KillName = ? WHERE KillName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IGC_PartyMatching SET PartyLeaderName = ? WHERE PartyLeaderName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IGC_PeriodBuffInfo SET CharacterName = ? WHERE CharacterName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IGC_PeriodItemInfo SET CharacterName = ? WHERE CharacterName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IGC_WaitPartyMatching SET LeaderName = ? WHERE LeaderName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IGC_WaitPartyMatching SET MemberName = ? WHERE MemberName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE OptionData SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_CGuid SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_CurCharName SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_Event_Inventory SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_FriendList SET FriendName = ? WHERE FriendName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_FriendMail SET FriendName = ? WHERE FriendName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_FriendMain SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_GMSystem SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_InGameShop_Items SET GiftName = ? WHERE GiftName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_LUCKY_ITEM_INFO SET CharName = ? WHERE CharName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_MineSystem SET CharacterName = ? WHERE CharacterName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_MuRummy SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_MuRummyInfo SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_MuRummyLog SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_PSHOP_ITEMVALUE_INFO SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_QUEST_EXP_INFO SET CHAR_NAME = ? WHERE CHAR_NAME = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE T_WaitFriend SET FriendName = ? WHERE FriendName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE vCharacterPreview SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_ACHIEVEMENTS SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_ACHIEVEMENTS_LOGS SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_ACHIEVEMENTS_RANKING SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_ACHIEVEMENTS_UNLOCK SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_ARCHITECT_BANK SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_ARCHITECT_BANK_LOGS SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_BAN_LOG SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_BANS SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_CHANGE_CLASS_LOGS SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_CHARACTER_PROGRESS_LOGS SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_CLAIM_REWARD SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_CLAIM_REWARD_LOGS SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_CLEAR_INV_LOGS SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_DUAL_SKILLTREE SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_DUAL_STATS SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_EDIT_CHAR_LOGS SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_RANKINGS_REWARDS_LOGS SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_STARTING_KIT_LOGS SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_TRANSFER_CHAR_LOGS SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_TRIGGER_CHARACTER SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_TRIGGER_EVENT SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_TRIGGER_MONSTER SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK_GUILD_LOGS SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE Character SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE Character SET MarryName = ? WHERE MarryName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO] SET CharacterName = ? WHERE CharacterName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_BC] SET CharacterName = ? WHERE CharacterName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_BC_3RD] SET CharacterName = ? WHERE CharacterName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_BC_4TH] SET CharacterName = ? WHERE CharacterName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_BC_5TH] SET CharacterName = ? WHERE CharacterName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_CC] SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_IT] SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[T_ENTER_CHECK_BC] SET CharName = ? WHERE CharName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[T_ENTER_CHECK_ILLUSION_TEMPLE] SET CharName = ? WHERE CharName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE [" . $config["SQL_DB_NAME_EVENTS"] . "].[dbo].[EVENT_INFO_BC_3RD] SET CharacterName = ? WHERE CharacterName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE [" . $config["SQL_DB_NAME_EVENTS"] . "].[dbo].[EVENT_INFO_BC_4TH] SET CharacterName = ? WHERE CharacterName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE [" . $config["SQL_DB_NAME_EVENTS"] . "].[dbo].[EVENT_INFO_BC_5TH] SET CharacterName = ? WHERE CharacterName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE [" . $config["SQL_DB_NAME_EVENTS"] . "].[dbo].[T_CC_OFFLINE_GIFT] SET CharName = ? WHERE CharName = ?", [$new_name, $old_name]);
                                        $dB->query("UPDATE [" . $config["SQL_DB_NAME_EVENTS"] . "].[dbo].[T_KanturuTimeAttackEvent2006] SET Name = ? WHERE Name = ?", [$new_name, $old_name]);
                                        message("success", sprintf(lang("renamechar_txt_8", true), $old_name, $new_name));
                                        $price_type = mconfig("credit_config");
                                        if ($price_type == "1") {
                                            $price_type = lang("currency_platinum", true);
                                        } else {
                                            if ($price_type == "2") {
                                                $price_type = lang("currency_gold", true);
                                            } else {
                                                if ($price_type == "3") {
                                                    $price_type = lang("currency_silver", true);
                                                } else {
                                                    if ($price_type == "4") {
                                                        $price_type = lang("currency_wcoinc", true);
                                                    } else {
                                                        if ($price_type == "5") {
                                                            $price_type = lang("currency_gp", true);
                                                        } else {
                                                            if ($price_type == "6") {
                                                                $price_type = "" . lang("currency_zen", true) . "";
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $price_type = mconfig("price") . " " . $price_type;
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($username, "renamecharacter", sprintf(lang("renamechar_txt_14", true), $old_name, $new_name, $price_type), $logDate);
                                        $dB->query("INSERT INTO IMPERIAMUCMS_CHANGE_NAME_LOGS (AccountID, OldName, NewName, price, price_type, date) VALUES (?, ?, ?, ?, ?, ?)", [$username, $old_name, $new_name, mconfig("price"), mconfig("credit_config"), date("Y-m-d H:i:s", time())]);
                                    } else {
                                        return NULL;
                                    }
                                } else {
                                    message("error", sprintf(lang("renamechar_txt_9", true), $new_name));
                                }
                            } else {
                                message("error", lang("renamechar_txt_10", true));
                            }
                        } else {
                            message("error", lang("renamechar_txt_11", true));
                        }
                    } else {
                        if (mconfig("allow_special_chars")) {
                            message("error", sprintf(lang("renamechar_txt_12", true), "a-z A-Z 0-9 _ ! ~ ^ @ # \$ ? [ ] ( ) { } = - + * / \\ |"));
                        } else {
                            message("error", sprintf(lang("renamechar_txt_12", true), "a-z A-Z 0-9"));
                        }
                    }
                } else {
                    message("error", lang("error_14", true));
                }
            } else {
                message("error", lang("renamechar_txt_13", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function changeClass($username, $char, $new_class)
    {
        global $dB;
        global $dB2;
        global $common;
        global $config;
        global $custom;
        if (check_value($username)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            $char = Decode($char);
            $new_class = Decode($new_class);
            if ($this->CharacterExists($char) && $this->CharacterBelongsToAccount($char, $username)) {
                if (!$common->accountOnline($username)) {
                    if ($custom["character_class"][$new_class][0] != NULL) {
                        $equipCheck = true;
                        if (mconfig("equip_check")) {
                            $index = 0;
                            $inventory = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = ? AND Name = ?), 2) AS Inventory", [$username, $char]);
                            $inventory = $inventory["Inventory"];
                            while ($index < 12) {
                                $item = substr($inventory, __ITEM_LENGTH__ * $index, __ITEM_LENGTH__);
                                if ($item != __ITEM_EMPTY__) {
                                    $equipCheck = false;
                                }
                                $index++;
                            }
                        }
                        if ($equipCheck) {
                            $coins_check = false;
                            if (0 < mconfig("price")) {
                                try {
                                    $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                                    $creditSystem->setConfigId(mconfig("credit_config"));
                                    $configSettings = $creditSystem->showConfigs(true);
                                    switch ($configSettings["config_user_col_id"]) {
                                        case "userid":
                                            $creditSystem->setIdentifier($_SESSION["userid"]);
                                            break;
                                        case "username":
                                            $creditSystem->setIdentifier($_SESSION["username"]);
                                            break;
                                        case "character":
                                            $creditSystem->setIdentifier($char);
                                            $creditSystem->subtractCredits(mconfig("price"));
                                            $coins_check = true;
                                            break;
                                        default:
                                            throw new Exception("Invalid identifier (credit system).");
                                    }
                                } catch (Exception $ex) {
                                    message("error", $ex->getMessage());
                                }
                            } else {
                                $coins_check = true;
                            }
                            if ($coins_check) {
                                $magicList = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT MagicList FROM Character WHERE AccountID = ? AND Name = ?), 2) AS magicList", [$username, $char]);
                                $magicList = $magicList["magicList"];
                                $newMagicList = $magicList;
                                $count = 0;
                                $magicListSize = 900;
                                $skillSize = 6;
                                $emptySkill = "FF0000";
                                if (132 <= config("server_files_season", true)) {
                                    $magicListSize = 3700;
                                    $skillSize = 10;
                                    $emptySkill = "FF00000000";
                                } else {
                                    if (130 <= config("server_files_season", true)) {
                                        $magicListSize = 4500;
                                        $skillSize = 10;
                                        $emptySkill = "FF00000000";
                                    }
                                }
                                $i = 0;
                                while ($i < $magicListSize) {
                                    $newMagicList = substr_replace($newMagicList, $emptySkill, $i, $skillSize);
                                    $i += $skillSize;
                                }
                                $quest = "0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000";
                                if (substr($newMagicList, 0, 2) != "0x") {
                                    $newMagicList = "0x" . $newMagicList;
                                }
                                $oldClass = $dB->query_fetch_single("SELECT Class FROM Character WHERE AccountID = ? AND Name = ?", [$username, $char]);
                                $update = $dB->query("UPDATE Character SET Class = ?, MagicList = " . $newMagicList . ", Quest = " . $quest . ", mlPoint = ? WHERE AccountID = ? AND Name = ?", [$new_class, $count, $username, $char]);
                                if ($update) {
                                    message("success", lang("changeclass_txt_9", true));
                                    $price_type = mconfig("credit_config");
                                    if ($price_type == "1") {
                                        $price_type = lang("currency_platinum", true);
                                    } else {
                                        if ($price_type == "2") {
                                            $price_type = lang("currency_gold", true);
                                        } else {
                                            if ($price_type == "3") {
                                                $price_type = lang("currency_silver", true);
                                            } else {
                                                if ($price_type == "4") {
                                                    $price_type = lang("currency_wcoinc", true);
                                                } else {
                                                    if ($price_type == "5") {
                                                        $price_type = lang("currency_gp", true);
                                                    } else {
                                                        if ($price_type == "6") {
                                                            $price_type = "" . lang("currency_zen", true) . "";
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    $price_type = mconfig("price") . " " . $price_type;
                                    $logDate = date("Y-m-d H:i:s", time());
                                    $common->accountLogs($username, "changeclass", sprintf(lang("changeclass_txt_10", true), $char, $custom["character_class"][$new_class][0], $price_type), $logDate);
                                    $dB->query("INSERT INTO IMPERIAMUCMS_CHANGE_CLASS_LOGS (AccountID, Name, OldClass, NewClass, price, price_type, date) VALUES (?, ?, ?, ?, ?, ?, ?)", [$username, $char, $oldClass["Class"], $new_class, mconfig("price"), mconfig("credit_config"), date("Y-m-d H:i:s", time())]);
                                } else {
                                    message("error", lang("error_23", true));
                                }
                            } else {
                                return NULL;
                            }
                        } else {
                            message("error", lang("changeclass_txt_8", true));
                        }
                    } else {
                        message("error", lang("changeclass_txt_7", true));
                    }
                } else {
                    message("error", lang("error_14", true));
                }
            } else {
                message("error", lang("renamechar_txt_13", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function addCharacterProgressLog($username, $char, $oldVal, $newVal, $type)
    {
        global $dB;
        global $config;
        if (check_value($username) && check_value($char) && check_value($oldVal) && check_value($newVal) && check_value($type)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if ($this->CharacterExists($char) && $this->CharacterBelongsToAccount($char, $username)) {
                $currMicrotime = microtime(true);
                $currTime = DateTime::createFromFormat("U.u", $currMicrotime);
                $currTime->setTimezone(new DateTimeZone($config["timezone_name"]));
                $getLastTime = $dB->query_fetch_single("SELECT TOP 1 Date FROM IMPERIAMUCMS_CHARACTER_PROGRESS_LOGS WHERE AccountID = ? AND Name = ? ORDER BY Date DESC", [$username, $char]);
                if ($getLastTime["Date"] != NULL) {
                    $format = "Y-m-d H:i:s.u";
                    $lastTime = DateTime::createFromFormat($format, $getLastTime["Date"]);
                    $lastTime->setTimezone(new DateTimeZone($config["timezone_name"]));
                    $diff = abs(strtotime($currTime->format("d-m-Y H:i:s.u")) - strtotime($lastTime->format("d-m-Y H:i:s.u")));
                    $micro1 = $currTime->format("u");
                    $micro2 = $lastTime->format("u");
                    $micro = abs($micro1 - $micro2);
                    $totalTime = $diff * 1000000 + $micro;
                } else {
                    $totalTime = NULL;
                }
                $dB->query("INSERT INTO IMPERIAMUCMS_CHARACTER_PROGRESS_LOGS (AccountID, Name, OldValue, NewValue, Type, Date, IP, TotalTime) \r\n                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [$username, $char, $oldVal, $newVal, $type, $currTime->format("Y-m-d H:i:s.u"), $_SERVER["REMOTE_ADDR"], $totalTime]);
            } else {
                message("error", lang("error_32", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function checkEquipment($username, $char, $applyCheck, $slot0, $slot1, $slot2, $slot3, $slot4, $slot5, $slot6, $slot7, $slot8, $slot9, $slot10, $slot11, $slot236, $slot237, $slot238)
    {
        global $dB;
        if (check_value($username) && check_value($char)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_23", true));
                return NULL;
            }
            if ($this->CharacterExists($char) && $this->CharacterBelongsToAccount($char, $username)) {
                if (!$applyCheck) {
                    return true;
                }
                $inventory = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = ? AND Name = ?), 2) AS items", [$username, $char]);
                $inventory = $inventory["items"];
                $error = false;
                $i = 0;
                if (132 <= config("server_files_season", true)) {
                    $whileLoop = 239;
                } else {
                    $whileLoop = 237;
                }
                while ($i < $whileLoop) {
                    if ($slot0 && $i == 0 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                        $error = true;
                    } else {
                        if ($slot1 && $i == 1 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                            $error = true;
                        } else {
                            if ($slot2 && $i == 2 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                                $error = true;
                            } else {
                                if ($slot3 && $i == 3 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                                    $error = true;
                                } else {
                                    if ($slot4 && $i == 4 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                                        $error = true;
                                    } else {
                                        if ($slot5 && $i == 5 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                                            $error = true;
                                        } else {
                                            if ($slot6 && $i == 6 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                                                $error = true;
                                            } else {
                                                if ($slot7 && $i == 7 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                                                    $error = true;
                                                } else {
                                                    if ($slot8 && $i == 8 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                                                        $error = true;
                                                    } else {
                                                        if ($slot9 && $i == 9 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                                                            $error = true;
                                                        } else {
                                                            if ($slot10 && $i == 10 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                                                                $error = true;
                                                            } else {
                                                                if ($slot11 && $i == 11 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                                                                    $error = true;
                                                                } else {
                                                                    if ($slot236 && $i == 236 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                                                                        $error = true;
                                                                    } else {
                                                                        if ($slot237 && $i == 237 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                                                                            $error = true;
                                                                        } else {
                                                                            if ($slot238 && $i == 238 && substr($inventory, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__) != __ITEM_EMPTY__) {
                                                                                $error = true;
                                                                            } else {
                                                                                if ($i == 11) {
                                                                                    $i = 235;
                                                                                }
                                                                                $i++;
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
                    }
                }
                if (!$error) {
                    return true;
                }
            } else {
                message("error", lang("error_32", true));
            }
        } else {
            message("error", lang("error_23", true));
        }
        return false;
    }
    public function loadCharacters($username)
    {
        global $dB;
        if (!Validator::UsernameLength($username)) {
            message("error", lang("error_5", true));
        } else {
            if (!Validator::AlphaNumeric($username)) {
                message("error", lang("error_6", true));
            } else {
                $charactersData = $dB->query_fetch("\r\n            SELECT AccountID, Name, Class, cLevel, mLevel, RESETS, Grand_Resets, Strength, Dexterity, Vitality, Energy, Leadership, LevelUpPoint, mlPoint, Money, MapNumber, MapPosX, MapPosY\r\n            FROM Character \r\n            WHERE AccountID = ?\r\n            ORDER BY Name ASC", [$username]);
            }
        }
    }
    public function findResetTypesStage($reset)
    {
        $resets = mconfig("resets");
        foreach ($resets["reset"] as $thisReset) {
            if ($thisReset["@attributes"]["req_reset_min"] <= $reset && $reset <= $thisReset["@attributes"]["req_reset_max"]) {
                return $thisReset;
            }
        }
        return NULL;
    }
    public function checkReqResetType($username, $charData, $resetStage)
    {
        $return = [];
        if ($charData["cLevel"] < $resetStage["@attributes"]["req_lvl"]) {
            $return["req_lvl"] = false;
        } else {
            $return["req_lvl"] = true;
        }
        if ($charData["mLevel"] < $resetStage["@attributes"]["req_mlvl"]) {
            $return["req_mlvl"] = false;
        } else {
            $return["req_mlvl"] = true;
        }
        if ($resetStage["@attributes"]["price_req"]) {
            $resetPrice = $resetStage["@attributes"]["price"];
            if ($resetStage["@attributes"]["price_formula"] == "1") {
                $resetPrice = ($charData["RESETS"] + 1) * $resetStage["@attributes"]["price"];
            }
            $actualCurrency = $this->checkReqCurrency($username, $charData["Name"], $resetStage["@attributes"]["price_type"]);
            if ($actualCurrency["currVal"] < $resetPrice) {
                $return["req_price"] = false;
            } else {
                $return["req_price"] = true;
            }
        } else {
            $return["req_price"] = true;
        }
        return $return;
    }
}

?>