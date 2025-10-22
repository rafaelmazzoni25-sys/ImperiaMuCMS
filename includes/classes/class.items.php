<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Items
{
    public function loadItemList()
    {
        $xml = file_get_contents(__PATH_INCLUDES__ . "files/IGCN/ItemList.xml");
        $xmlArray = [];
        $result = [];
        $p = xml_parser_create();
        xml_parse_into_struct($p, $xml, $xmlArray);
        xml_parser_free($p);
        $i = 0;
        foreach ($xmlArray as $element) {
            if ($element["tag"] == "ITEM") {
                $result[$i] = $element;
                $i++;
            }
        }
        return $result;
    }
    public function loadItemFromItemList($id, $index)
    {
        $return = [];
        $xml = simplexml_load_file(__PATH_INCLUDES__ . "files/IGCN/ItemList.xml");
        if ($xml !== false) {
            foreach ($xml->Section as $tag_sec => $section) {
                if ($section["Index"] == $id) {
                    foreach ($section->Item as $tag_item => $item) {
                        if ($item["Index"] == $index) {
                            $return["id"] = $id;
                            $return["index"] = $index;
                            $return["Slot"] = intval($item["Slot"]);
                            $return["Option"] = intval($item["Option"]);
                            $return["Type"] = intval($item["Type"]);
                            $return["KindA"] = intval($item["KindA"]);
                            $return["KindB"] = intval($item["KindB"]);
                            $return["SkillIndex"] = intval($item["SkillIndex"]);
                            $return["DropLevel"] = intval($item["DropLevel"]);
                            $return["TwoHand"] = intval($item["TwoHand"]);
                            $return["DamageMin"] = intval($item["DamageMin"]);
                            $return["DamageMax"] = intval($item["DamageMax"]);
                            $return["Defense"] = intval($item["Defense"]);
                            $return["AttackSpeed"] = intval($item["AttackSpeed"]);
                            $return["Durability"] = intval($item["Durability"]);
                            $return["MagicDurability"] = intval($item["MagicDurability"]);
                            $return["MagicPower"] = intval($item["MagicPower"]);
                            $return["ReqLevel"] = intval($item["ReqLevel"]);
                            $return["ReqStrength"] = intval($item["ReqStrength"]);
                            $return["ReqDexterity"] = intval($item["ReqDexterity"]);
                            $return["ReqEnergy"] = intval($item["ReqEnergy"]);
                            $return["ReqVitality"] = intval($item["ReqVitality"]);
                            $return["ReqCommand"] = intval($item["ReqCommand"]);
                            $return["DarkWizard"] = intval($item["DarkWizard"]);
                            $return["DarkKnight"] = intval($item["DarkKnight"]);
                            $return["FairyElf"] = intval($item["FairyElf"]);
                            $return["MagicGladiator"] = intval($item["MagicGladiator"]);
                            $return["DarkLord"] = intval($item["DarkLord"]);
                            $return["Summoner"] = intval($item["Summoner"]);
                            $return["RageFighter"] = intval($item["RageFighter"]);
                            $return["GrowLancer"] = intval($item["GrowLancer"]);
                            $return["RuneWizard"] = intval($item["RuneWizard"]);
                            $return["Slayer"] = intval($item["Slayer"]);
                            return $return;
                        }
                    }
                }
            }
        }
    }
    public function loadExcOptForItem($id, $index, $kindA, $kindB)
    {
        $return = [];
        $xml = simplexml_load_file(__PATH_INCLUDES__ . "files/IGCN/ExcellentOptions.xml");
        if ($xml !== false) {
            $i = 0;
            if ($kindA == "1" || $kindA == "2" || $kindA == "3" || $kindA == "4" || $kindA == "14" || $kindA == "15" || $kindA == "18" || $kindA == "100") {
                foreach ($xml->Common->children() as $tag => $option) {
                    if ($kindA == $option["ItemKindA_1"] || $kindA == $option["ItemKindA_2"] || $kindA == $option["ItemKindA_3"] || $kindA == $option["ItemKindA_4"]) {
                        $return[$i]["ID"] = intval($option["ID"]);
                        $return[$i]["Number"] = intval($option["Number"]);
                        $return[$i]["Operator"] = intval($option["Operator"]);
                        $return[$i]["Value"] = intval($option["Value"]);
                        $return[$i]["FormulaID"] = intval($option["FormulaID"]);
                        $return[$i]["Name"] = strval($option["Name"]);
                        $i++;
                    }
                }
            } else {
                if ($kindA == "6") {
                    foreach ($xml->Wings->children() as $tag => $option) {
                        if ($kindA == $option["ItemKindA"] && $kindB == $option["ItemKindB"]) {
                            $return[$i]["ID"] = intval($option["ID"]);
                            $return[$i]["Number"] = intval($option["Number"]);
                            $return[$i]["Operator"] = intval($option["Operator"]);
                            $return[$i]["Value"] = intval($option["Value"]);
                            $return[$i]["FormulaID"] = intval($option["FormulaID"]);
                            $return[$i]["Name"] = strval($option["Name"]);
                            $i++;
                        }
                    }
                }
            }
            return $return;
        }
    }
    public function loadExcOptFormula($id)
    {
        $return = [];
        $xml = simplexml_load_file(__PATH_INCLUDES__ . "files/IGCN/FormulaData.xml");
        if ($xml !== false) {
            foreach ($xml->ExcellentOption->children() as $tag => $option) {
                if ($option["ID"] == $id) {
                    $return["ID"] = $id;
                    $return["Data"] = strval($option["Data"]);
                    return $return;
                }
            }
        }
    }
    public function calculateValueByFormula($id, $string, $dropLevel)
    {
        if ($id == "0" || $id == "6") {
            $string = sprintf($string, $dropLevel, 400);
        } else {
            $string = sprintf($string, $dropLevel);
        }
        $value = eval("return (" . $string . ");");
        return ceil($value);
    }
    public function loadGradeOptForItem()
    {
        $return = [];
        $xml = simplexml_load_file(__PATH_INCLUDES__ . "files/IGCN/ItemGradeOption.xml");
        if ($xml !== false) {
            $i = 0;
            foreach ($xml->List->children() as $tag => $option) {
                $return[$i]["Index"] = intval($option["Index"]);
                $return[$i]["ItemKindB"] = intval($option["ItemKindB"]);
                $return[$i]["Grade0Val"] = intval($option["Grade0Val"]);
                $return[$i]["Grade1Val"] = intval($option["Grade1Val"]);
                $return[$i]["Grade2Val"] = intval($option["Grade2Val"]);
                $return[$i]["Grade3Val"] = intval($option["Grade3Val"]);
                $return[$i]["Grade4Val"] = intval($option["Grade4Val"]);
                $return[$i]["Grade5Val"] = intval($option["Grade5Val"]);
                $return[$i]["Grade6Val"] = intval($option["Grade6Val"]);
                $return[$i]["Grade7Val"] = intval($option["Grade7Val"]);
                $return[$i]["Grade8Val"] = intval($option["Grade8Val"]);
                $return[$i]["Grade9Val"] = intval($option["Grade9Val"]);
                $return[$i]["Rate"] = intval($option["Rate"]);
                $return[$i]["Name"] = strval($option["Name"]);
                $i++;
            }
            return $return;
        }
    }
    public function loadPentagramOptForWings()
    {
        $return = [];
        $xml = simplexml_load_file(__PATH_INCLUDES__ . "files/IGCN/PentagramWingAttribute.xml");
        if ($xml !== false) {
            $j = 0;
            foreach ($xml->MainOption as $tag => $option) {
                $return["main"][$j]["Value0"] = intval($option["Value0"]);
                $return["main"][$j]["Value1"] = intval($option["Value1"]);
                $return["main"][$j]["Value2"] = intval($option["Value2"]);
                $return["main"][$j]["Value3"] = intval($option["Value3"]);
                $return["main"][$j]["Value4"] = intval($option["Value4"]);
                $return["main"][$j]["Value5"] = intval($option["Value5"]);
                $return["main"][$j]["Value6"] = intval($option["Value6"]);
                $return["main"][$j]["Value7"] = intval($option["Value7"]);
                $return["main"][$j]["Value8"] = intval($option["Value8"]);
                $return["main"][$j]["Value9"] = intval($option["Value9"]);
                $return["main"][$j]["Value10"] = intval($option["Value10"]);
                $return["main"][$j]["Value11"] = intval($option["Value11"]);
                $return["main"][$j]["Value12"] = intval($option["Value12"]);
                $return["main"][$j]["Value13"] = intval($option["Value13"]);
                $return["main"][$j]["Value14"] = intval($option["Value14"]);
                $return["main"][$j]["Value15"] = intval($option["Value15"]);
                $return["main"][$j]["Name"] = strval($option["Name"]);
                $j++;
            }
            $i = 0;
            foreach ($xml->AdditionalOptions->children() as $tag => $option) {
                $return["add"][$i]["Index"] = intval($option["Index"]);
                $return["add"][$i]["Value0"] = intval($option["Value0"]);
                $return["add"][$i]["Value1"] = intval($option["Value1"]);
                $return["add"][$i]["Value2"] = intval($option["Value2"]);
                $return["add"][$i]["Value3"] = intval($option["Value3"]);
                $return["add"][$i]["Value4"] = intval($option["Value4"]);
                $return["add"][$i]["Value5"] = intval($option["Value5"]);
                $return["add"][$i]["Value6"] = intval($option["Value6"]);
                $return["add"][$i]["Value7"] = intval($option["Value7"]);
                $return["add"][$i]["Value8"] = intval($option["Value8"]);
                $return["add"][$i]["Value9"] = intval($option["Value9"]);
                $return["add"][$i]["Value10"] = intval($option["Value10"]);
                $return["add"][$i]["Value11"] = intval($option["Value11"]);
                $return["add"][$i]["Value12"] = intval($option["Value12"]);
                $return["add"][$i]["Value13"] = intval($option["Value13"]);
                $return["add"][$i]["Value14"] = intval($option["Value14"]);
                $return["add"][$i]["Value15"] = intval($option["Value15"]);
                $return["add"][$i]["Name"] = strval($option["Name"]);
                $i++;
            }
            return $return;
        }
    }
    public function detect4thWingsExcOpt($gradeOpts, $socDec)
    {
        $socHex = sprintf("%02X", $socDec);
        $excOptIndex = hexdec($socHex[0]);
        $excOptLvl = hexdec($socHex[1]);
        foreach ($gradeOpts as $thisGrade) {
            if ($thisGrade["Index"] == $excOptIndex) {
                return sprintf(lang("exc_opt_wings_4th_" . $excOptIndex, true), $thisGrade["Grade" . $excOptLvl . "Val"]);
            }
        }
    }
    public function detect4thWingsMainElemOpt($mainOpts, $harmonyDec)
    {
        $harmonyHex = sprintf("%02X", $harmonyDec);
        $elemOptIndex = hexdec($harmonyHex[0]);
        $elemOptLvl = hexdec($harmonyHex[1]);
        foreach ($mainOpts as $thisOpt) {
            if ($thisOpt["Index"] == $elemOptIndex) {
                return sprintf(lang("pentagram_main_opt_4th_wings_0", true), $thisOpt["Value" . $elemOptLvl]);
            }
        }
    }
    public function detect4thWingsAdditionalElemOpt($additionalOpts, $socDec)
    {
        $socHex = sprintf("%02X", $socDec);
        $elemOptIndex = hexdec($socHex[0]);
        $elemOptLvl = hexdec($socHex[1]);
        foreach ($additionalOpts as $thisOpt) {
            if ($thisOpt["Index"] == $elemOptIndex) {
                return sprintf(lang("pentagram_add_opt_4th_wings_" . $elemOptIndex, true), $thisOpt["Value" . $elemOptLvl]);
            }
        }
    }
    public function errtel($type, $id, $rank, $level)
    {
        switch ($type) {
            case 221:
                if ($id == 1) {
                    $dmg = ["30", "33", "38", "45", "54", "65", "78", "93", "113", "138", "168"];
                    $errtel = $rank == 1 ? "Elemental damage " . $dmg[$level] : NULL;
                }
                if ($id == 2) {
                    $dmg = ["5", "6", "7", "8", "9", "10", "12", "14", "16", "18", "20"];
                    $element = ["1" => "Fire Element", "2" => "Water Element", "3" => "Earth Element", "4" => "Wind Element", "5" => "Dark Element"];
                    $errtel = $dmg[$level] . "% Attack Against " . $element[$rank];
                }
                if ($id == 3) {
                    $dmg = ["30", "35", "43", "54", "66", "80", "97", "117", "142", "172", "207"];
                    $element = ["1" => "in PvP", "2" => "in Raids"];
                    $errtel = "Elemental Attack Dmg (" . $element[$rank] . ") +" . $dmg[$level];
                }
                if ($id == 4) {
                    $dmg = ["5", "6", "7", "8", "10", "12", "14", "17", "20", "23", "27"];
                    $element = ["1" => "in Raids", "2" => "in PvP"];
                    $errtel = "Elemental Damage (" . $element[$rank] . ") +" . $dmg[$level] . "%";
                }
                if ($id == 5) {
                    $dmg = ["3", "4", "5", "6", "8", "10", "12", "15", "18", "21", "25"];
                    $errtel = "Elemental Damage +" . $dmg[$level] . "%";
                }
                break;
            case 231:
                if ($id == 1) {
                    $dmg = ["10", "13", "17", "22", "28", "35", "43", "52", "62", "73", "85"];
                    $errtel = $rank == 1 ? "Additional Elemental Defense " . $dmg[$level] : NULL;
                }
                if ($id == 2) {
                    $dmg = ["5", "6", "7", "8", "9", "10", "12", "14", "16", "18", "20"];
                    $element = ["1" => "Fire Element", "2" => "Water Element", "3" => "Earth Element", "4" => "Wind Element", "5" => "Dark Element"];
                    $errtel = $dmg[$level] . "% Defense Against " . $element[$rank];
                }
                if ($id == 3) {
                    $dmg = ["10", "13", "17", "22", "28", "35", "43", "52", "62", "73", "85"];
                    $element = ["1" => "in PvP", "2" => "in Raids"];
                    $errtel = "Elemental Defense (" . $element[$rank] . ") +" . $dmg[$level];
                }
                if ($id == 4) {
                    $dmg = ["5", "6", "7", "8", "10", "12", "14", "17", "20", "23", "27"];
                    $element = ["1" => "in Raids", "2" => "in PvP"];
                    $errtel = "Elemental Damage Absorb (" . $element[$rank] . ") +" . $dmg[$level] . "%";
                }
                if ($id == 5) {
                    $dmg = ["3", "4", "5", "6", "8", "10", "12", "15", "18", "21", "25"];
                    $errtel = "Elemental Damage Absorb +" . $dmg[$level] . "%";
                }
                break;
            case 241:
                if ($id == 1) {
                    $dmg = ["5", "6", "7", "8", "9", "10", "12", "14", "16", "18", "20"];
                    $errtel = $rank == 1 ? "Elemental Attack Success Rate " . $dmg[$level] . "%" : NULL;
                }
                if ($id == 2) {
                    $dmg = ["5", "6", "7", "8", "9", "10", "12", "14", "16", "18", "20"];
                    $element = ["1" => "Fire Element", "2" => "Water Element", "3" => "Earth Element", "4" => "Wind Element", "5" => "Dark Element"];
                    $errtel = $dmg[$level] . "% Attack Against " . $element[$rank];
                }
                if ($id == 3) {
                    $dmg = ["30", "35", "43", "54", "66", "80", "97", "117", "142", "172", "207"];
                    $element = ["1" => "in PvP", "2" => "in Raids"];
                    $errtel = "Elemental Attack Dmg (" . $element[$rank] . ") +" . $dmg[$level];
                }
                if ($id == 4) {
                    $dmg = ["270", "300", "330", "360", "410", "460", "510", "570", "630", "690", "800"];
                    $element = ["1" => "in Raids", "2" => "in PvP"];
                    $errtel = "Elemental Attack Success Rate (" . $element[$rank] . ") +" . $dmg[$level];
                }
                if ($id == 5) {
                    $dmg = ["150", "170", "190", "210", "240", "270", "300", "340", "380", "420", "500"];
                    $errtel = "Attack Success Rate +" . $dmg[$level];
                }
                break;
            case 251:
                if ($id == 1) {
                    $dmg = ["5", "6", "7", "8", "9", "10", "12", "14", "16", "18", "20"];
                    $errtel = $rank == 1 ? "Elemental Defense Success Rate " . $dmg[$level] . "%" : NULL;
                }
                if ($id == 2) {
                    $dmg = ["5", "6", "7", "8", "9", "10", "12", "14", "16", "18", "20"];
                    $element = ["1" => "Fire Element", "2" => "Water Element", "3" => "Earth Element", "4" => "Wind Element", "5" => "Dark Element"];
                    $errtel = $dmg[$level] . "% Defense Against " . $element[$rank];
                }
                if ($id == 3) {
                    $dmg = ["10", "13", "17", "22", "28", "35", "43", "52", "62", "73", "85"];
                    $element = ["1" => "in PvP", "2" => "in Raids"];
                    $errtel = "Elemental Defense (" . $element[$rank] . ") +" . $dmg[$level];
                }
                if ($id == 4) {
                    $dmg = ["270", "300", "330", "360", "410", "460", "510", "570", "630", "690", "800"];
                    $element = ["1" => "in Raids", "2" => "in PvP"];
                    $errtel = "Elemental Attack Success Rate (" . $element[$rank] . ") +" . $dmg[$level];
                }
                if ($id == 5) {
                    $dmg = ["150", "170", "190", "210", "240", "270", "300", "340", "380", "420", "500"];
                    $element = ["1" => "in PvP", "2" => "in PvE"];
                    $errtel = "Elemental Defense Success Rate +" . $dmg[$level];
                }
                break;
            case 261:
                if ($id == 1) {
                    $dmg[1] = ["33", "48", "63", "78", "95", "112", "129", "148", "167", "186", "209"];
                    $dmg[2] = ["13", "21", "29", "37", "46", "55", "64", "74", "84", "94", "107"];
                    $dmg[3] = ["150", "173", "196", "219", "252", "285", "318", "361", "404", "447", "605"];
                    $dmg[4] = ["150", "173", "196", "219", "252", "285", "318", "361", "404", "447", "605"];
                    $dmg[5] = ["33", "52", "71", "90", "120", "141", "162", "191", "213", "235", "261"];
                    $dmg[6] = ["13", "23", "33", "43", "54", "65", "76", "90", "104", "118", "135"];
                    $element = ["1" => "Elemental Damage (II)", "2" => "Elemental Defense (II)", "3" => "Elemental Attack Success Rate (II)", "4" => "Elemental Defense Success Rate (II)", "5" => "Elemental Damage (III)", "6" => "Elemental Defense (III)"];
                    $errtel = $element[$rank] . " +" . $dmg[$rank][$level];
                }
                if ($id == 2) {
                    $dmg[1] = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "1"];
                    $dmg[2] = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "1"];
                    $dmg[3] = ["3", "4", "5", "6", "8", "10", "12", "15", "18", "21", "25"];
                    $element = ["1" => "Absorb Shield - 30% chance to absorb", "2" => "Absorb Life - 30% chance to absorb", "3" => "Bastion - Protection is actived for"];
                    $elementEnd = ["1" => "% damage as SD", "2" => "% damage as Life", "3" => " sec. by 50% chance when SD is below 20%"];
                    $errtel = $element[$rank] . " " . $dmg[$rank][$level] . $elementEnd[$rank];
                }
                if ($id == 3) {
                    $dmg[1] = ["150", "170", "190", "210", "240", "270", "300", "340", "380", "420", "500"];
                    $dmg[2] = NULL;
                    $dmg[3] = NULL;
                    $dmg[4] = ["6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16"];
                    $dmg[5] = ["10", "13", "17", "22", "28", "35", "43", "52", "62", "73", "85"];
                    $element = ["1" => "Bleeding - A durable effect invoking", "2" => "Paralyzing - Chance to decrease targets Moving Speed and every Healing ability by 90%", "3" => "Binding - Immobilize the target by holding its leg with certain chance when attacking.", "4" => "Punish- 30%% chance to inflict damage (", "5" => "Blinding - Chance to greatly decrease targets Attack Success Rate by"];
                    $elementEnd = ["1" => " damages to the target with certain chance when attacking", "2" => NULL, "3" => NULL, "4" => "% of targets MAX Life) upon Critical Elemantal Damage.", "5" => "% when attacking."];
                    $errtel = $element[$rank] . " " . $dmg[$rank][$level] . $elementEnd[$rank];
                }
                if ($id == 4) {
                    $element = ["1" => "Can use Immune Skill I.", "2" => "Can use Immune Skill II."];
                    $errtel = $element[$rank];
                }
                if ($id == 5) {
                    $errtel = "Can use Berseker Skill I.";
                }
                break;
            default:
                return $errtel;
        }
    }
    public function ItemInfo($_item, $username = NULL, $charName = NULL, $location = 0)
    {
        global $dB;
        global $custom;
        if (substr($_item, 0, 2) == "0x") {
            $_item = substr($_item, 2);
        }
        if (strlen($_item) != __ITEM_LENGTH__ || !preg_match("/(^[a-zA-Z0-9])/", $_item) || $_item == __ITEM_EMPTY__) {
            return false;
        }
        $bulo = $_item;
        $sy = hexdec(substr($_item, 0, 2));
        $iop = hexdec(substr($_item, 2, 2));
        $itemdur = hexdec(substr($_item, 4, 2));
        $serial2 = substr($_item, 6, 8);
        $serial = substr($_item, 32, 8);
        $ioo = hexdec(substr($_item, 14, 2));
        $ac = hexdec(substr($_item, 16, 2));
        $itemtype = hexdec(substr($_item, 18, 1));
        $jog = hexdec(substr($_item, 19, 1));
        $harm = hexdec(substr($_item, 20, 1));
        $harmlvl = hexdec(substr($_item, 21, 1));
        $fullHarmony = hexdec(substr($_item, 20, 2));
        $socket = substr($_item, 22, 10);
        $soc1 = hexdec(substr($_item, 22, 2));
        $soc2 = hexdec(substr($_item, 24, 2));
        $soc3 = hexdec(substr($_item, 26, 2));
        $soc4 = hexdec(substr($_item, 28, 2));
        $soc5 = hexdec(substr($_item, 30, 2));
        if (128 <= $ioo) {
            $sy = $sy + 256;
            $ioo -= 128;
        }
        $itemListData = $this->loadItemFromItemList($itemtype, $sy);
        $availableExcOpts = $this->loadExcOptForItem($itemtype, $sy, $itemListData["KindA"], $itemListData["KindB"]);
        if ($jog == 8) {
            switch ($itemtype) {
                case 7:
                    $jogopt = lang("market_txt_10", true);
                    break;
                case 8:
                    $jogopt = lang("market_txt_11", true);
                    break;
                case 9:
                    $jogopt = lang("market_txt_12", true);
                    break;
                case 10:
                    $jogopt = lang("market_txt_13", true);
                    break;
                case 11:
                    $jogopt = lang("market_txt_14", true);
                    break;
                default:
                    $jogopt = lang("market_txt_15", true);
                    $isjog = 1;
            }
        } else {
            $isjog = 0;
        }
        if ($harm != 0 && $itemListData["Type"] != "2") {
            $harm_code = $harm;
            $harmon = $this->harmony($itemtype, $harm, $harmlvl);
        } else {
            $harmon = "";
        }
        $excopt_sx_1 = -1;
        $excopt_sx_2 = -1;
        $excopt_sx_3 = -1;
        $excopt_sx_4 = -1;
        $excopt_sx_5 = -1;
        $is_excopt_sx_1 = 0;
        $is_excopt_sx_2 = 0;
        $is_excopt_sx_3 = 0;
        $is_excopt_sx_4 = 0;
        $is_excopt_sx_5 = 0;
        $excopt_sx_total = 0;
        if ($socket != "FFFFFFFFFF") {
            if ($itemListData["KindA"] == "8" && $itemListData["KindB"] == "43") {
                $sock = "";
            } else {
                if ($itemListData["Type"] == "2") {
                    $sock = "<span style=&quot;color: var(--item-color-socket-opt);&quot;>" . lang("market_txt_16", true) . "</span>";
                    $bonus_socket = hexdec(substr($_item, 20, 2));
                    $ancTmp = $ac;
                    $soc1_flag = false;
                    $soc2_flag = false;
                    $soc3_flag = false;
                    $soc4_flag = false;
                    $soc5_flag = false;
                    if (122 <= config("server_files_season", true)) {
                        if (64 <= $ancTmp) {
                            $soc1 += 254;
                            $ancTmp -= 64;
                            $soc1_flag = true;
                        }
                        if (16 <= $ancTmp) {
                            $soc2 += 254;
                            $ancTmp -= 16;
                            $soc2_flag = true;
                        }
                        if (4 <= $ancTmp) {
                            $soc3 += 254;
                            $ancTmp -= 4;
                            $soc3_flag = true;
                        }
                        if (1 <= $ancTmp) {
                            $soc4 += 254;
                            $ancTmp -= 1;
                            $soc4_flag = true;
                        }
                        if (16 <= $ioo) {
                            $soc5 += 254;
                            $soc5_flag = true;
                        }
                    }
                    $soc1opt = $this->getSocketOption($soc1, $soc1_flag);
                    $soc2opt = $this->getSocketOption($soc2, $soc2_flag);
                    $soc3opt = $this->getSocketOption($soc3, $soc3_flag);
                    $soc4opt = $this->getSocketOption($soc4, $soc4_flag);
                    $soc5opt = $this->getSocketOption($soc5, $soc5_flag);
                    $socket1name = $soc1 != 254 || $soc1 == 254 && $soc1_flag ? sprintf(lang($soc1opt["socket_name_lang"], true), $soc1opt["socket_lvl"], $soc1opt["socket_value"]) : $soc1opt["socket_name"];
                    $socket2name = $soc2 != 254 || $soc2 == 254 && $soc2_flag ? sprintf(lang($soc2opt["socket_name_lang"], true), $soc2opt["socket_lvl"], $soc2opt["socket_value"]) : $soc2opt["socket_name"];
                    $socket3name = $soc3 != 254 || $soc3 == 254 && $soc3_flag ? sprintf(lang($soc3opt["socket_name_lang"], true), $soc3opt["socket_lvl"], $soc3opt["socket_value"]) : $soc3opt["socket_name"];
                    $socket4name = $soc4 != 254 || $soc4 == 254 && $soc4_flag ? sprintf(lang($soc4opt["socket_name_lang"], true), $soc4opt["socket_lvl"], $soc4opt["socket_value"]) : $soc4opt["socket_name"];
                    $socket5name = $soc5 != 254 || $soc5 == 254 && $soc5_flag ? sprintf(lang($soc5opt["socket_name_lang"], true), $soc5opt["socket_lvl"], $soc5opt["socket_value"]) : $soc5opt["socket_name"];
                    if ($soc1 != 255 || $soc1 == 255 && $soc1_flag) {
                        $sock .= "<br>" . lang("market_txt_17", true) . " 1: " . $socket1name;
                    }
                    if ($soc2 != 255 || $soc2 == 255 && $soc2_flag) {
                        $sock .= "<br>" . lang("market_txt_17", true) . " 2: " . $socket2name;
                    }
                    if ($soc3 != 255 || $soc3 == 255 && $soc3_flag) {
                        $sock .= "<br>" . lang("market_txt_17", true) . " 3: " . $socket3name;
                    }
                    if ($soc4 != 255 || $soc4 == 255 && $soc4_flag) {
                        $sock .= "<br>" . lang("market_txt_17", true) . " 4: " . $socket4name;
                    }
                    if ($soc5 != 255 || $soc5 == 255 && $soc5_flag) {
                        $sock .= "<br>" . lang("market_txt_17", true) . " 5: " . $socket5name;
                    }
                    if ($bonus_socket != 255) {
                        $sock .= "<br><br><span style=&quot;color: var(--item-color-socket-opt);&quot;>" . lang("socket_bonus", true) . "</span>";
                        $bonusSocketOption = $this->getSocketBonusOption($bonus_socket);
                        if ($bonusSocketOption["socket_lvl"] == "1") {
                            $socketBonusLvl = "socket_bonus_lvl1";
                        } else {
                            $socketBonusLvl = "socket_bonus_lvl2";
                        }
                        $socketBonusName = sprintf(lang($bonusSocketOption["socket_name_lang"], true), lang($socketBonusLvl, true), $bonusSocketOption["socket_value"]);
                        $sock .= "<br>" . $socketBonusName;
                    }
                } else {
                    if (100 <= config("server_files_season", true)) {
                        if ($itemListData["KindA"] == "1" || $itemListData["KindA"] == "2") {
                            foreach ($availableExcOpts as $thisOpt) {
                                if ($soc1 == $thisOpt["Number"]) {
                                    $excopt_sx_1 = $thisOpt["Number"];
                                    $is_excopt_sx_1 = 1;
                                    $excopt_sx_total++;
                                } else {
                                    if ($soc2 == $thisOpt["Number"]) {
                                        $excopt_sx_2 = $thisOpt["Number"];
                                        $is_excopt_sx_2 = 1;
                                        $excopt_sx_total++;
                                    }
                                }
                            }
                        } else {
                            if ($itemListData["KindA"] == "14" || $itemListData["KindA"] == "15" || $itemListData["KindA"] == "18") {
                                foreach ($availableExcOpts as $thisOpt) {
                                    if (($thisOpt["ID"] == 6 || $thisOpt["ID"] == 14) && ($thisOpt["Number"] == $soc1 || $thisOpt["Number"] == $soc2 || $thisOpt["Number"] == $soc3 || $thisOpt["Number"] == $soc4)) {
                                        $excopt_sx_1 = $thisOpt["Number"];
                                        $is_excopt_sx_1 = 1;
                                        $excopt_sx_total++;
                                    }
                                    if (($thisOpt["ID"] == 7 || $thisOpt["ID"] == 15) && ($thisOpt["Number"] == $soc1 || $thisOpt["Number"] == $soc2 || $thisOpt["Number"] == $soc3 || $thisOpt["Number"] == $soc4)) {
                                        $excopt_sx_2 = $thisOpt["Number"];
                                        $is_excopt_sx_2 = 1;
                                        $excopt_sx_total++;
                                    }
                                    if ($thisOpt["ID"] == 16 && ($thisOpt["Number"] == $soc1 || $thisOpt["Number"] == $soc2 || $thisOpt["Number"] == $soc3 || $thisOpt["Number"] == $soc4)) {
                                        $excopt_sx_3 = $thisOpt["Number"];
                                        $is_excopt_sx_3 = 1;
                                        $excopt_sx_total++;
                                    }
                                    if (($thisOpt["ID"] == 17 || $thisOpt["ID"] == 18) && ($thisOpt["Number"] == $soc1 || $thisOpt["Number"] == $soc2 || $thisOpt["Number"] == $soc3 || $thisOpt["Number"] == $soc4)) {
                                        $excopt_sx_4 = $thisOpt["Number"];
                                        $is_excopt_sx_4 = 1;
                                        $excopt_sx_total++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $ancTier = 0;
        if ($ac == 6 || $ac == 10) {
            $ancTier = 2;
        } else {
            if ($ac == 5 || $ac == 9) {
                $ancTier = 1;
            }
        }
        $ac_sta = 0;
        if ($ac == 5 || $ac == 6) {
            $ac_sta = 5;
        }
        if ($ac == 9 || $ac == 10) {
            $ac_sta = 10;
        }
        if ($iop < 128) {
            $skill = "";
            $skill2 = 0;
        } else {
            $skill = lang("market_txt_18", true);
            $skill2 = 1;
            $iop = $iop - 128;
        }
        $itemlevel = floor($iop / 8);
        $iop = $iop - $itemlevel * 8;
        if ($iop < 4) {
            $luck = "";
            $luck2 = 0;
        } else {
            $luck = lang("market_txt_19", true);
            $luck2 = 1;
            $iop = $iop - 4;
        }
        if ($itemtype == 12 || $sy == 30 && $itemtype == 13) {
            if (96 <= $ioo) {
                $lifeOptType = 2;
            } else {
                if (80 <= $ioo) {
                    $lifeOptType = 3;
                } else {
                    if (64 <= $ioo) {
                        $lifeOptType = 1;
                    }
                }
            }
        }
        $is_exc_1 = 0;
        $is_exc_2 = 0;
        $is_exc_3 = 0;
        $is_exc_4 = 0;
        $is_exc_5 = 0;
        $is_exc_6 = 0;
        if (64 <= $ioo) {
            $iop += 4;
            $ioo += -64;
        }
        if ($ioo < 32) {
            $iopx6 = 0;
        } else {
            $iopx6 = 1;
            $ioo += -32;
            if ($itemListData["KindA"] == "1" || $itemListData["KindA"] == "2" || $itemListData["KindA"] == "3" || $itemListData["KindA"] == "4" || $itemListData["KindA"] == "14") {
                $is_exc_1 = 1;
            }
        }
        if ($ioo < 16) {
            $iopx5 = 0;
        } else {
            $iopx5 = 1;
            $ioo += -16;
            if ($itemListData["KindA"] == "1" || $itemListData["KindA"] == "2" || $itemListData["KindA"] == "3" || $itemListData["KindA"] == "4") {
                $is_exc_2 = 1;
            }
        }
        if ($ioo < 8) {
            $iopx4 = 0;
        } else {
            $iopx4 = 1;
            $ioo += -8;
            if ($itemListData["KindA"] == "1" || $itemListData["KindA"] == "2" || $itemListData["KindA"] == "3" || $itemListData["KindA"] == "4") {
                $is_exc_3 = 1;
            }
        }
        if ($ioo < 4) {
            $iopx3 = 0;
        } else {
            $iopx3 = 1;
            $ioo += -4;
            if ($itemListData["KindA"] == "1" || $itemListData["KindA"] == "2" || $itemListData["KindA"] == "3" || $itemListData["KindA"] == "4") {
                $is_exc_4 = 1;
            } else {
                if ($itemListData["KindA"] == "15" || $itemListData["KindA"] == "18") {
                    $is_exc_1 = 1;
                } else {
                    if ($itemListData["KindA"] == "14") {
                        $is_exc_2 = 1;
                    }
                }
            }
        }
        if ($ioo < 2) {
            $iopx2 = 0;
        } else {
            $iopx2 = 1;
            $ioo += -2;
            if ($itemListData["KindA"] == "1" || $itemListData["KindA"] == "2" || $itemListData["KindA"] == "3" || $itemListData["KindA"] == "4") {
                $is_exc_5 = 1;
            } else {
                if ($itemListData["KindA"] == "15" || $itemListData["KindA"] == "18") {
                    $is_exc_2 = 1;
                } else {
                    if ($itemListData["KindA"] == "14") {
                        $is_exc_3 = 1;
                    }
                }
            }
        }
        if ($ioo < 1) {
            $iopx1 = 0;
        } else {
            $iopx1 = 1;
            $ioo += -1;
            if ($itemListData["KindA"] == "1" || $itemListData["KindA"] == "2" || $itemListData["KindA"] == "3" || $itemListData["KindA"] == "4") {
                $is_exc_6 = 1;
            } else {
                if ($itemListData["KindA"] == "14") {
                    $is_exc_4 = 1;
                }
            }
        }
        $exl2 = 0;
        if ($iopx6 == 1) {
            $exl2 += 32;
        }
        if ($iopx5 == 1) {
            $exl2 += 16;
        }
        if ($iopx4 == 1) {
            $exl2 += 8;
        }
        if ($iopx3 == 1) {
            $exl2 += 4;
        }
        if ($iopx2 == 1) {
            $exl2 += 2;
        }
        if ($iopx1 == 1) {
            $exl2 += 1;
        }
        $fquery = $dB->query_fetch_single("SELECT * FROM [IMPERIAMUCMS_ITEMS] WHERE [id]=" . $sy . " AND [type]=" . $itemtype . " AND [level]=" . $itemlevel);
        if (empty($fquery)) {
            $fquery = $dB->query_fetch_single("SELECT * FROM [IMPERIAMUCMS_ITEMS] WHERE [id]=" . $sy . " AND [type]=" . $itemtype);
            $nolevel = 0;
        } else {
            $nolevel = 1;
        }
        $fresult = $fquery;
        $iopxltype = $fresult["exc"];
        $itemname = $fresult["name"];
        if (!$fresult) {
            return false;
        }
        $itemexl = "";
        if (100 <= config("server_files_season", true)) {
            switch ($itemListData["KindA"]) {
                case 1:
                    break;
                case 2:
                    $op1 = lang("exc_opt_item_5", true);
                    $op2 = lang("exc_opt_item_4", true);
                    $op3 = lang("exc_opt_item_3", true);
                    $op4 = lang("exc_opt_item_2", true);
                    $op5 = lang("exc_opt_item_1", true);
                    $op6 = lang("exc_opt_item_0", true);
                    $inf = lang("market_txt_26", true);
                    break;
                case 3:
                    break;
                case 4:
                    $op1 = lang("exc_opt_item_13", true);
                    $op2 = lang("exc_opt_item_12", true);
                    $op3 = lang("exc_opt_item_11", true);
                    $op4 = lang("exc_opt_item_10", true);
                    $op5 = lang("exc_opt_item_9", true);
                    $op6 = lang("exc_opt_item_8", true);
                    $inf = lang("market_txt_33", true);
                    $skill = "";
                    break;
                case 14:
                    $op1 = lang("exc_opt_item_5", true);
                    $op2 = lang("exc_opt_item_4", true);
                    $op3 = lang("exc_opt_item_3", true);
                    $op6 = lang("exc_opt_item_0", true);
                    $op7 = lang("exc_opt_item_6", true);
                    $op8 = lang("exc_opt_item_7", true);
                    $inf = lang("market_txt_26", true);
                    break;
                case 15:
                    $op2 = lang("exc_opt_item_12", true);
                    $op3 = lang("exc_opt_item_11", true);
                    $op7 = lang("exc_opt_item_14", true);
                    $op8 = lang("exc_opt_item_15", true);
                    $op9 = lang("exc_opt_item_16", true);
                    $op10 = lang("exc_opt_item_17", true);
                    $inf = lang("market_txt_33", true);
                    $skill = "";
                    break;
                case 18:
                    $op2 = lang("exc_opt_item_12", true);
                    $op3 = lang("exc_opt_item_11", true);
                    $op7 = lang("exc_opt_item_14", true);
                    $op8 = lang("exc_opt_item_15", true);
                    $op9 = lang("exc_opt_item_16", true);
                    $op10 = lang("exc_opt_item_18", true);
                    $inf = lang("market_txt_33", true);
                    $skill = "";
                    break;
                case 19:
                    if ($itemListData["Slot"] == "238") {
                        if ($itemListData["index"] == "450") {
                            $op1 = lang("exc_opt_earring_left_5", true);
                            $op2 = lang("exc_opt_earring_left_6", true);
                            $op3 = lang("exc_opt_earring_left_7", true);
                            $op4 = lang("exc_opt_earring_left_8", true);
                            $op5 = lang("exc_opt_earring_left_9", true);
                        } else {
                            $op1 = lang("exc_opt_earring_left_0", true);
                            $op2 = lang("exc_opt_earring_left_1", true);
                            $op3 = lang("exc_opt_earring_left_2", true);
                            $op4 = lang("exc_opt_earring_left_3", true);
                            $op5 = lang("exc_opt_earring_left_4", true);
                        }
                    } else {
                        if ($itemListData["Slot"] == "237") {
                            if ($itemListData["index"] == "458") {
                                $op1 = lang("exc_opt_earring_right_5", true);
                                $op2 = lang("exc_opt_earring_right_6", true);
                                $op3 = lang("exc_opt_earring_right_7", true);
                                $op4 = lang("exc_opt_earring_right_8", true);
                                $op5 = lang("exc_opt_earring_right_9", true);
                            } else {
                                $op1 = lang("exc_opt_earring_right_0", true);
                                $op2 = lang("exc_opt_earring_right_1", true);
                                $op3 = lang("exc_opt_earring_right_2", true);
                                $op4 = lang("exc_opt_earring_right_3", true);
                                $op5 = lang("exc_opt_earring_right_4", true);
                            }
                        }
                    }
                    $skill = "";
                    break;
                case 6:
                    if ($itemListData["KindB"] == "24") {
                        $op1 = lang("exc_opt_wings_4", true);
                        $op2 = lang("exc_opt_wings_3", true);
                        $op3 = lang("exc_opt_wings_2", true);
                        $op4 = lang("exc_opt_wings_1", true);
                        $op5 = lang("exc_opt_wings_0", true);
                        $op6 = "";
                        $inf = lang("market_txt_26", true);
                        $skill = "";
                        $nocolor = true;
                    } else {
                        if ($itemListData["KindB"] == "25") {
                            $op1 = lang("exc_opt_wings_8", true);
                            $op2 = lang("exc_opt_wings_7", true);
                            $op3 = lang("exc_opt_wings_6", true);
                            $op4 = lang("exc_opt_wings_5", true);
                            $op5 = "";
                            $op6 = "";
                            $inf = lang("market_txt_26", true);
                            $skill = "";
                            $nocolor = true;
                        } else {
                            if ($itemListData["KindB"] == "26") {
                                $op1 = lang("exc_opt_wings_12", true);
                                $op2 = lang("exc_opt_wings_11", true);
                                $op3 = lang("exc_opt_wings_10", true);
                                $op4 = lang("exc_opt_wings_9", true);
                                $op5 = "";
                                $op6 = "";
                                $inf = lang("market_txt_26", true);
                                $skill = "";
                                $nocolor = true;
                            } else {
                                if ($itemListData["KindB"] == "27") {
                                    $op1 = lang("exc_opt_wings_15", true);
                                    $op2 = lang("exc_opt_wings_14", true);
                                    $op3 = lang("exc_opt_wings_13", true);
                                    $op4 = "";
                                    $op5 = "";
                                    $op6 = "";
                                    $inf = lang("market_txt_26", true);
                                    $skill = "";
                                    $nocolor = true;
                                } else {
                                    if ($itemListData["KindB"] == "28") {
                                        $op1 = lang("exc_opt_wings_17", true);
                                        $op2 = lang("exc_opt_wings_16", true);
                                        $op3 = "";
                                        $op4 = "";
                                        $op5 = "";
                                        $op6 = "";
                                        $inf = lang("market_txt_26", true);
                                        $skill = "";
                                        $nocolor = true;
                                    } else {
                                        if ($itemListData["KindB"] == "60") {
                                            $op1 = lang("exc_opt_wings_21", true);
                                            $op2 = lang("exc_opt_wings_20", true);
                                            $op3 = lang("exc_opt_wings_19", true);
                                            $op4 = lang("exc_opt_wings_18", true);
                                            $op5 = "";
                                            $op6 = "";
                                            $inf = lang("market_txt_26", true);
                                            $skill = "";
                                            $nocolor = true;
                                        } else {
                                            if ($itemListData["KindB"] == "62") {
                                                $op1 = lang("exc_opt_wings_24", true);
                                                $op2 = lang("exc_opt_wings_23", true);
                                                $op3 = lang("exc_opt_wings_22", true);
                                                $op4 = "";
                                                $op5 = "";
                                                $op6 = "";
                                                $inf = lang("market_txt_26", true);
                                                $skill = "";
                                                $nocolor = true;
                                            } else {
                                                if ($itemListData["KindB"] == "76") {
                                                    $op1 = lang("exc_opt_wings_4th_0", true);
                                                    $op2 = lang("exc_opt_wings_4th_1", true);
                                                    $op3 = lang("exc_opt_wings_4th_2", true);
                                                    $op4 = lang("exc_opt_wings_4th_3", true);
                                                    $op5 = lang("exc_opt_wings_4th_4", true);
                                                    $op6 = lang("exc_opt_wings_4th_5", true);
                                                    $op7 = lang("exc_opt_wings_4th_6", true);
                                                    $op8 = lang("exc_opt_wings_4th_7", true);
                                                    $op9 = lang("exc_opt_wings_4th_8", true);
                                                    $op10 = lang("exc_opt_wings_4th_9", true);
                                                    $op11 = lang("exc_opt_wings_4th_10", true);
                                                    $inf = lang("market_txt_26", true);
                                                    $skill = "";
                                                    $nocolor = true;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    break;
            }
        } else {
            switch ($iopxltype) {
                case 1:
                    $op1 = lang("market_txt_20", true);
                    $op2 = lang("market_txt_21", true);
                    $op3 = lang("market_txt_22", true);
                    $op4 = lang("market_txt_23", true);
                    $op5 = lang("market_txt_24", true);
                    $op6 = lang("market_txt_25", true);
                    $inf = lang("market_txt_26", true);
                    break;
                case 2:
                    $op1 = lang("market_txt_27", true);
                    $op2 = lang("market_txt_28", true);
                    $op3 = lang("market_txt_29", true);
                    $op4 = lang("market_txt_30", true);
                    $op5 = lang("market_txt_31", true);
                    $op6 = lang("market_txt_32", true);
                    $inf = lang("market_txt_33", true);
                    $skill = "";
                    break;
                case 3:
                    $op1 = lang("market_txt_34", true);
                    $op2 = lang("market_txt_35", true);
                    $op3 = lang("market_txt_36", true);
                    $op4 = lang("market_txt_37", true);
                    $op5 = lang("market_txt_38", true);
                    $op6 = "";
                    $inf = lang("market_txt_26", true);
                    $skill = "";
                    $nocolor = true;
                    break;
                case 4:
                    $op1 = lang("market_txt_39", true);
                    $op2 = lang("market_txt_40", true);
                    $op3 = lang("market_txt_41", true);
                    $op4 = lang("market_txt_42", true);
                    $op5 = "";
                    $op6 = "";
                    $inf = lang("market_txt_26", true);
                    $skill = "";
                    $nocolor = true;
                    break;
                case 5:
                    $op1 = lang("market_txt_34", true);
                    $op2 = lang("market_txt_35", true);
                    $op3 = lang("market_txt_36", true);
                    $op4 = lang("market_txt_43", true);
                    $op5 = "";
                    $op6 = "";
                    $inf = lang("market_txt_26", true);
                    $skill = "";
                    $nocolor = true;
                    break;
                case 6:
                    $op1 = lang("market_txt_34", true);
                    $op2 = lang("market_txt_35", true);
                    $op3 = lang("market_txt_36", true);
                    $op4 = "";
                    $op5 = "";
                    $op6 = "";
                    $inf = lang("market_txt_26", true);
                    $skill = "";
                    $nocolor = true;
                    break;
                case 7:
                    $op1 = lang("market_txt_36", true);
                    $op2 = lang("market_txt_41", true);
                    $op3 = "";
                    $op4 = "";
                    $op5 = "";
                    $op6 = "";
                    $inf = lang("market_txt_26", true);
                    $skill = "";
                    $nocolor = true;
                    break;
                case 8:
                    $op1 = lang("market_txt_44", true);
                    $op2 = lang("market_txt_45", true);
                    $op3 = lang("market_txt_46", true);
                    $op4 = "";
                    $op5 = "";
                    $op6 = "";
                    $inf = lang("market_txt_26", true);
                    $skill = "";
                    $nocolor = true;
                    break;
                case 9:
                    $op1 = lang("market_txt_47", true);
                    $op2 = lang("market_txt_48", true);
                    $op3 = lang("market_txt_49", true);
                    $op4 = lang("market_txt_50", true);
                    $op5 = "";
                    $op6 = "";
                    $inf = lang("market_txt_26", true);
                    $skill = "";
                    $nocolor = true;
                    break;
            }
        }
        if ($itemListData["Type"] == "2" && config("server_files_season", true) < 100 || $itemListData["Type"] != "2") {
            if (100 <= config("server_files_season", true)) {
                if ($itemListData["KindA"] == "6" && $itemListData["KindB"] == "24") {
                    $excOptIndex = 4;
                } else {
                    if ($itemListData["KindA"] == "6" && ($itemListData["KindB"] == "25" || $itemListData["KindB"] == "26" || $itemListData["KindB"] == "60")) {
                        $excOptIndex = 3;
                    } else {
                        if ($itemListData["KindA"] == "6" && ($itemListData["KindB"] == "27" || $itemListData["KindB"] == "62")) {
                            $excOptIndex = 2;
                        } else {
                            if ($itemListData["KindA"] == "6" && $itemListData["KindB"] == "28") {
                                $excOptIndex = 1;
                            } else {
                                if ($itemListData["KindA"] == "14") {
                                    $excOptIndex = 3;
                                } else {
                                    $excOptIndex = 5;
                                }
                            }
                        }
                    }
                }
                if ($availableExcOpts[$excOptIndex]["FormulaID"] != "-1" && "0" <= $availableExcOpts[$excOptIndex]["FormulaID"]) {
                    $formulaData = $this->loadExcOptFormula($availableExcOpts[$excOptIndex]["FormulaID"]);
                    $optValue = $this->calculateValueByFormula($availableExcOpts[$excOptIndex]["FormulaID"], $formulaData["Data"], $itemListData["DropLevel"]);
                } else {
                    if ($availableExcOpts[$excOptIndex]["Operator"] == "6") {
                        $optValue = $availableExcOpts[$excOptIndex]["Value"] + $itemlevel * 5;
                    } else {
                        $optValue = $availableExcOpts[$excOptIndex]["Value"];
                    }
                }
                if ($availableExcOpts[$excOptIndex]["ID"] != "1" && $availableExcOpts[$excOptIndex]["ID"] != "2" && $availableExcOpts[$excOptIndex]["ID"] != "6" && $availableExcOpts[$excOptIndex]["ID"] != "7" && $availableExcOpts[$excOptIndex]["ID"] != "18" || $itemListData["KindA"] == "6") {
                    $op1 = sprintf($op1, $optValue);
                } else {
                    if ($itemtype == "5") {
                        $excOptStringTmp = lang("item_detail_txt_13", true);
                    } else {
                        $excOptStringTmp = lang("item_detail_txt_12", true);
                    }
                    if ($availableExcOpts[$excOptIndex]["ID"] == "1") {
                        $op1 = sprintf($op1, $excOptStringTmp, $optValue);
                    } else {
                        if ($availableExcOpts[$excOptIndex]["ID"] == "2") {
                            $op1 = sprintf($op1, $excOptStringTmp, $optValue);
                        } else {
                            if ($availableExcOpts[$excOptIndex]["ID"] == "6") {
                                $op1 = sprintf($op1, $excOptStringTmp, $optValue);
                            } else {
                                if ($availableExcOpts[$excOptIndex]["ID"] == "7") {
                                    $op1 = sprintf($op1, $excOptStringTmp, $optValue);
                                } else {
                                    if ($availableExcOpts[$excOptIndex]["ID"] == "18") {
                                        $op1 = sprintf($op1, lang("item_detail_txt_17", true), $optValue);
                                    }
                                }
                            }
                        }
                    }
                }
                if ($iopx1 == 1) {
                    $itemexl = "^^" . $op1 . $itemexl;
                }
                if ($itemListData["KindA"] == "14") {
                    $excOptIndex = 2;
                } else {
                    if ($itemListData["KindA"] == "15" || $itemListData["KindA"] == "18") {
                        $excOptIndex = 1;
                    } else {
                        if ($itemListData["KindA"] == "6" && $itemListData["KindB"] == "24") {
                            $excOptIndex = 3;
                        } else {
                            if ($itemListData["KindA"] == "6" && ($itemListData["KindB"] == "25" || $itemListData["KindB"] == "26" || $itemListData["KindB"] == "60")) {
                                $excOptIndex = 2;
                            } else {
                                if ($itemListData["KindA"] == "6" && ($itemListData["KindB"] == "27" || $itemListData["KindB"] == "62")) {
                                    $excOptIndex = 1;
                                } else {
                                    if ($itemListData["KindA"] == "6" && $itemListData["KindB"] == "28") {
                                        $excOptIndex = 0;
                                    } else {
                                        $excOptIndex = 4;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($availableExcOpts[$excOptIndex]["FormulaID"] != "-1" && "0" <= $availableExcOpts[$excOptIndex]["FormulaID"]) {
                    $formulaData = $this->loadExcOptFormula($availableExcOpts[$excOptIndex]["FormulaID"]);
                    $optValue = $this->calculateValueByFormula($availableExcOpts[$excOptIndex]["FormulaID"], $formulaData["Data"], $itemListData["DropLevel"]);
                } else {
                    if ($availableExcOpts[$excOptIndex]["Operator"] == "6") {
                        $optValue = $availableExcOpts[$excOptIndex]["Value"] + $itemlevel * 5;
                    } else {
                        $optValue = $availableExcOpts[$excOptIndex]["Value"];
                    }
                }
                if ($availableExcOpts[$excOptIndex]["ID"] != "1" && $availableExcOpts[$excOptIndex]["ID"] != "2" && $availableExcOpts[$excOptIndex]["ID"] != "6" && $availableExcOpts[$excOptIndex]["ID"] != "7" && $availableExcOpts[$excOptIndex]["ID"] != "18" || $itemListData["KindA"] == "6") {
                    $op2 = sprintf($op2, $optValue);
                } else {
                    if ($itemtype == "5") {
                        $excOptStringTmp = lang("item_detail_txt_13", true);
                    } else {
                        $excOptStringTmp = lang("item_detail_txt_12", true);
                    }
                    if ($availableExcOpts[$excOptIndex]["ID"] == "1") {
                        $op2 = sprintf($op2, $excOptStringTmp, $optValue);
                    } else {
                        if ($availableExcOpts[$excOptIndex]["ID"] == "2") {
                            $op2 = sprintf($op2, $excOptStringTmp, $optValue);
                        } else {
                            if ($availableExcOpts[$excOptIndex]["ID"] == "6") {
                                $op2 = sprintf($op2, $excOptStringTmp, $optValue);
                            } else {
                                if ($availableExcOpts[$excOptIndex]["ID"] == "7") {
                                    $op2 = sprintf($op2, $excOptStringTmp, $optValue);
                                } else {
                                    if ($availableExcOpts[$excOptIndex]["ID"] == "18") {
                                        $op2 = sprintf($op2, lang("item_detail_txt_17", true), $optValue);
                                    }
                                }
                            }
                        }
                    }
                }
                if ($iopx2 == 1) {
                    $itemexl = "^^" . $op2 . $itemexl;
                }
                if ($itemListData["KindA"] == "14") {
                    $excOptIndex = 1;
                } else {
                    if ($itemListData["KindA"] == "15" || $itemListData["KindA"] == "18") {
                        $excOptIndex = 0;
                    } else {
                        if ($itemListData["KindA"] == "6" && $itemListData["KindB"] == "24") {
                            $excOptIndex = 2;
                        } else {
                            if ($itemListData["KindA"] == "6" && ($itemListData["KindB"] == "25" || $itemListData["KindB"] == "26" || $itemListData["KindB"] == "60")) {
                                $excOptIndex = 1;
                            } else {
                                if ($itemListData["KindA"] == "6" && ($itemListData["KindB"] == "27" || $itemListData["KindB"] == "62")) {
                                    $excOptIndex = 0;
                                } else {
                                    $excOptIndex = 3;
                                }
                            }
                        }
                    }
                }
                if ($availableExcOpts[$excOptIndex]["FormulaID"] != "-1" && "0" <= $availableExcOpts[$excOptIndex]["FormulaID"]) {
                    $formulaData = $this->loadExcOptFormula($availableExcOpts[$excOptIndex]["FormulaID"]);
                    $optValue = $this->calculateValueByFormula($availableExcOpts[$excOptIndex]["FormulaID"], $formulaData["Data"], $itemListData["DropLevel"]);
                } else {
                    $optValue = $availableExcOpts[$excOptIndex]["Value"];
                }
                if ($availableExcOpts[$excOptIndex]["ID"] != "1" && $availableExcOpts[$excOptIndex]["ID"] != "2" && $availableExcOpts[$excOptIndex]["ID"] != "6" && $availableExcOpts[$excOptIndex]["ID"] != "7" && $availableExcOpts[$excOptIndex]["ID"] != "18" || $itemListData["KindA"] == "6") {
                    $op3 = sprintf($op3, $optValue);
                } else {
                    if ($itemtype == "5") {
                        $excOptStringTmp = lang("item_detail_txt_13", true);
                    } else {
                        $excOptStringTmp = lang("item_detail_txt_12", true);
                    }
                    if ($availableExcOpts[$excOptIndex]["ID"] == "1") {
                        $op3 = sprintf($op3, $excOptStringTmp, $optValue);
                    } else {
                        if ($availableExcOpts[$excOptIndex]["ID"] == "2") {
                            $op3 = sprintf($op3, $excOptStringTmp, $optValue);
                        } else {
                            if ($availableExcOpts[$excOptIndex]["ID"] == "6") {
                                $op3 = sprintf($op3, $excOptStringTmp, $optValue);
                            } else {
                                if ($availableExcOpts[$excOptIndex]["ID"] == "7") {
                                    $op3 = sprintf($op3, $excOptStringTmp, $optValue);
                                } else {
                                    if ($availableExcOpts[$excOptIndex]["ID"] == "18") {
                                        $op3 = sprintf($op3, lang("item_detail_txt_17", true), $optValue);
                                    }
                                }
                            }
                        }
                    }
                }
                if ($iopx3 == 1) {
                    $itemexl = "^^" . $op3 . $itemexl;
                }
                if ($itemListData["KindA"] == "6" && $itemListData["KindB"] == "24") {
                    $excOptIndex = 1;
                } else {
                    if ($itemListData["KindA"] == "6" && ($itemListData["KindB"] == "25" || $itemListData["KindB"] == "26" || $itemListData["KindB"] == "60")) {
                        $excOptIndex = 0;
                    } else {
                        $excOptIndex = 2;
                    }
                }
                if ($availableExcOpts[$excOptIndex]["FormulaID"] != "-1" && "0" <= $availableExcOpts[$excOptIndex]["FormulaID"]) {
                    $formulaData = $this->loadExcOptFormula($availableExcOpts[$excOptIndex]["FormulaID"]);
                    $optValue = $this->calculateValueByFormula($availableExcOpts[$excOptIndex]["FormulaID"], $formulaData["Data"], $itemListData["DropLevel"]);
                } else {
                    if ($availableExcOpts[$excOptIndex]["Operator"] == "6") {
                        $optValue = $availableExcOpts[$excOptIndex]["Value"] + $itemlevel * 5;
                    } else {
                        $optValue = $availableExcOpts[$excOptIndex]["Value"];
                    }
                }
                if ($availableExcOpts[$excOptIndex]["ID"] != "1" && $availableExcOpts[$excOptIndex]["ID"] != "2" && $availableExcOpts[$excOptIndex]["ID"] != "6" && $availableExcOpts[$excOptIndex]["ID"] != "7" && $availableExcOpts[$excOptIndex]["ID"] != "18" || $itemListData["KindA"] == "6") {
                    $op4 = sprintf($op4, $optValue);
                } else {
                    if ($itemtype == "5") {
                        $excOptStringTmp = lang("item_detail_txt_13", true);
                    } else {
                        $excOptStringTmp = lang("item_detail_txt_12", true);
                    }
                    if ($availableExcOpts[$excOptIndex]["ID"] == "1") {
                        $op4 = sprintf($op4, $excOptStringTmp, $optValue);
                    } else {
                        if ($availableExcOpts[$excOptIndex]["ID"] == "2") {
                            $op4 = sprintf($op4, $excOptStringTmp, $optValue);
                        } else {
                            if ($availableExcOpts[$excOptIndex]["ID"] == "6") {
                                $op4 = sprintf($op4, $excOptStringTmp, $optValue);
                            } else {
                                if ($availableExcOpts[$excOptIndex]["ID"] == "7") {
                                    $op4 = sprintf($op4, $excOptStringTmp, $optValue);
                                } else {
                                    if ($availableExcOpts[$excOptIndex]["ID"] == "18") {
                                        $op4 = sprintf($op4, lang("item_detail_txt_17", true), $optValue);
                                    }
                                }
                            }
                        }
                    }
                }
                if ($iopx4 == 1) {
                    $itemexl = "^^" . $op4 . $itemexl;
                }
                if ($itemListData["KindA"] == "6" && $itemListData["KindB"] == "24") {
                    $excOptIndex = 0;
                } else {
                    $excOptIndex = 1;
                }
                if ($availableExcOpts[$excOptIndex]["FormulaID"] != "-1" && "0" <= $availableExcOpts[$excOptIndex]["FormulaID"]) {
                    $formulaData = $this->loadExcOptFormula($availableExcOpts[$excOptIndex]["FormulaID"]);
                    $optValue = $this->calculateValueByFormula($availableExcOpts[$excOptIndex]["FormulaID"], $formulaData["Data"], $itemListData["DropLevel"]);
                } else {
                    $optValue = $availableExcOpts[$excOptIndex]["Value"];
                }
                if ($availableExcOpts[$excOptIndex]["ID"] != "1" && $availableExcOpts[$excOptIndex]["ID"] != "2" && $availableExcOpts[$excOptIndex]["ID"] != "6" && $availableExcOpts[$excOptIndex]["ID"] != "7" && $availableExcOpts[$excOptIndex]["ID"] != "18" || $itemListData["KindA"] == "6") {
                    $op5 = sprintf($op5, $optValue);
                } else {
                    if ($itemtype == "5") {
                        $excOptStringTmp = lang("item_detail_txt_13", true);
                    } else {
                        $excOptStringTmp = lang("item_detail_txt_12", true);
                    }
                    if ($availableExcOpts[$excOptIndex]["ID"] == "1") {
                        $op5 = sprintf($op5, $excOptStringTmp, $optValue);
                    } else {
                        if ($availableExcOpts[$excOptIndex]["ID"] == "2") {
                            $op5 = sprintf($op5, $excOptStringTmp, $optValue);
                        } else {
                            if ($availableExcOpts[$excOptIndex]["ID"] == "6") {
                                $op5 = sprintf($op5, $excOptStringTmp, $optValue);
                            } else {
                                if ($availableExcOpts[$excOptIndex]["ID"] == "7") {
                                    $op5 = sprintf($op5, $excOptStringTmp, $optValue);
                                } else {
                                    if ($availableExcOpts[$excOptIndex]["ID"] == "18") {
                                        $op5 = sprintf($op5, lang("item_detail_txt_17", true), $optValue);
                                    }
                                }
                            }
                        }
                    }
                }
                if ($iopx5 == 1) {
                    $itemexl = "^^" . $op5 . $itemexl;
                }
                if ($availableExcOpts[0]["FormulaID"] != "-1" && "0" <= $availableExcOpts[0]["FormulaID"]) {
                    $formulaData = $this->loadExcOptFormula($availableExcOpts[0]["FormulaID"]);
                    $optValue = $this->calculateValueByFormula($availableExcOpts[0]["FormulaID"], $formulaData["Data"], $itemListData["DropLevel"]);
                } else {
                    $optValue = $availableExcOpts[0]["Value"];
                }
                if ($availableExcOpts[0]["ID"] != "1" && $availableExcOpts[0]["ID"] != "2" && $availableExcOpts[0]["ID"] != "6" && $availableExcOpts[0]["ID"] != "7" && $availableExcOpts[0]["ID"] != "18" || $itemListData["KindA"] == "6") {
                    $op6 = sprintf($op6, $optValue);
                } else {
                    if ($itemtype == "5") {
                        $excOptStringTmp = lang("item_detail_txt_13", true);
                    } else {
                        $excOptStringTmp = lang("item_detail_txt_12", true);
                    }
                    if ($availableExcOpts[0]["ID"] == "1") {
                        $op6 = sprintf($op6, $excOptStringTmp, $optValue);
                    } else {
                        if ($availableExcOpts[0]["ID"] == "2") {
                            $op6 = sprintf($op6, $excOptStringTmp, $optValue);
                        } else {
                            if ($availableExcOpts[0]["ID"] == "6") {
                                $op6 = sprintf($op6, $excOptStringTmp, $optValue);
                            } else {
                                if ($availableExcOpts[0]["ID"] == "7") {
                                    $op6 = sprintf($op6, $excOptStringTmp, $optValue);
                                } else {
                                    if ($availableExcOpts[$excOptIndex]["ID"] == "18") {
                                        $op6 = sprintf($op6, lang("item_detail_txt_17", true), $optValue);
                                    }
                                }
                            }
                        }
                    }
                }
                if ($iopx6 == 1) {
                    $itemexl = "^^" . $op6 . $itemexl;
                }
                if ($itemListData["KindA"] == "19") {
                    if ($itemListData["id"] == "12" && $itemListData["index"] == "449") {
                        if ($soc1 == "153") {
                            $itemexl .= "^^" . $op1;
                        } else {
                            if ($soc1 == "188") {
                                $itemexl .= "^^" . $op2;
                            } else {
                                if ($soc1 == "150") {
                                    $itemexl .= "^^" . $op3;
                                } else {
                                    if ($soc1 == "134") {
                                        $itemexl .= "^^" . $op4;
                                    } else {
                                        if ($soc1 == "88") {
                                            $itemexl .= "^^" . $op5;
                                        }
                                    }
                                }
                            }
                        }
                        if ($soc2 == "188") {
                            $itemexl .= "^^" . $op2;
                        } else {
                            if ($soc2 == "150") {
                                $itemexl .= "^^" . $op3;
                            } else {
                                if ($soc2 == "134") {
                                    $itemexl .= "^^" . $op4;
                                } else {
                                    if ($soc2 == "88") {
                                        $itemexl .= "^^" . $op5;
                                    }
                                }
                            }
                        }
                        if ($soc3 == "150") {
                            $itemexl .= "^^" . $op3;
                        } else {
                            if ($soc3 == "134") {
                                $itemexl .= "^^" . $op4;
                            } else {
                                if ($soc3 == "88") {
                                    $itemexl .= "^^" . $op5;
                                }
                            }
                        }
                        if ($soc4 == "134") {
                            $itemexl .= "^^" . $op4;
                        } else {
                            if ($soc4 == "88") {
                                $itemexl .= "^^" . $op5;
                            }
                        }
                        if ($soc5 == "88") {
                            $itemexl .= "^^" . $op5;
                        }
                    } else {
                        if ($itemListData["id"] == "12" && $itemListData["index"] == "457") {
                            if ($soc1 == "77") {
                                $itemexl .= "^^" . $op1;
                            } else {
                                if ($soc1 == "138") {
                                    $itemexl .= "^^" . $op2;
                                } else {
                                    if ($soc1 == "122") {
                                        $itemexl .= "^^" . $op3;
                                    } else {
                                        if ($soc1 == "115") {
                                            $itemexl .= "^^" . $op4;
                                        } else {
                                            if ($soc1 == "96") {
                                                $itemexl .= "^^" . $op5;
                                            }
                                        }
                                    }
                                }
                            }
                            if ($soc2 == "138") {
                                $itemexl .= "^^" . $op2;
                            } else {
                                if ($soc2 == "122") {
                                    $itemexl .= "^^" . $op3;
                                } else {
                                    if ($soc2 == "115") {
                                        $itemexl .= "^^" . $op4;
                                    } else {
                                        if ($soc2 == "96") {
                                            $itemexl .= "^^" . $op5;
                                        }
                                    }
                                }
                            }
                            if ($soc3 == "122") {
                                $itemexl .= "^^" . $op3;
                            } else {
                                if ($soc3 == "115") {
                                    $itemexl .= "^^" . $op4;
                                } else {
                                    if ($soc3 == "96") {
                                        $itemexl .= "^^" . $op5;
                                    }
                                }
                            }
                            if ($soc4 == "115") {
                                $itemexl .= "^^" . $op4;
                            } else {
                                if ($soc4 == "96") {
                                    $itemexl .= "^^" . $op5;
                                }
                            }
                            if ($soc5 == "96") {
                                $itemexl .= "^^" . $op5;
                            }
                        } else {
                            if ($itemListData["id"] == "12" && $itemListData["index"] == "450") {
                                if ($soc1 == "153") {
                                    $itemexl .= "^^" . $op1;
                                } else {
                                    if ($soc1 == "228") {
                                        $itemexl .= "^^" . $op2;
                                    } else {
                                        if ($soc1 == "238") {
                                            $itemexl .= "^^" . $op3;
                                        } else {
                                            if ($soc1 == "246") {
                                                $itemexl .= "^^" . $op4;
                                            } else {
                                                if ($soc1 == "88") {
                                                    $itemexl .= "^^" . $op5;
                                                }
                                            }
                                        }
                                    }
                                }
                                if ($soc2 == "228") {
                                    $itemexl .= "^^" . $op2;
                                } else {
                                    if ($soc2 == "238") {
                                        $itemexl .= "^^" . $op3;
                                    } else {
                                        if ($soc2 == "246") {
                                            $itemexl .= "^^" . $op4;
                                        } else {
                                            if ($soc2 == "88") {
                                                $itemexl .= "^^" . $op5;
                                            }
                                        }
                                    }
                                }
                                if ($soc3 == "238") {
                                    $itemexl .= "^^" . $op3;
                                } else {
                                    if ($soc3 == "246") {
                                        $itemexl .= "^^" . $op4;
                                    } else {
                                        if ($soc3 == "88") {
                                            $itemexl .= "^^" . $op5;
                                        }
                                    }
                                }
                                if ($soc4 == "246") {
                                    $itemexl .= "^^" . $op4;
                                } else {
                                    if ($soc4 == "88") {
                                        $itemexl .= "^^" . $op5;
                                    }
                                }
                                if ($soc5 == "88") {
                                    $itemexl .= "^^" . $op5;
                                }
                            } else {
                                if ($itemListData["id"] == "12" && $itemListData["index"] == "458") {
                                    if ($soc1 == "77") {
                                        $itemexl .= "^^" . $op1;
                                    } else {
                                        if ($soc1 == "138") {
                                            $itemexl .= "^^" . $op2;
                                        } else {
                                            if ($soc1 == "122") {
                                                $itemexl .= "^^" . $op3;
                                            } else {
                                                if ($soc1 == "115") {
                                                    $itemexl .= "^^" . $op4;
                                                } else {
                                                    if ($soc1 == "96") {
                                                        $itemexl .= "^^" . $op5;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if ($soc2 == "138") {
                                        $itemexl .= "^^" . $op2;
                                    } else {
                                        if ($soc2 == "122") {
                                            $itemexl .= "^^" . $op3;
                                        } else {
                                            if ($soc2 == "115") {
                                                $itemexl .= "^^" . $op4;
                                            } else {
                                                if ($soc2 == "96") {
                                                    $itemexl .= "^^" . $op5;
                                                }
                                            }
                                        }
                                    }
                                    if ($soc3 == "122") {
                                        $itemexl .= "^^" . $op3;
                                    } else {
                                        if ($soc3 == "115") {
                                            $itemexl .= "^^" . $op4;
                                        } else {
                                            if ($soc3 == "96") {
                                                $itemexl .= "^^" . $op5;
                                            }
                                        }
                                    }
                                    if ($soc4 == "115") {
                                        $itemexl .= "^^" . $op4;
                                    } else {
                                        if ($soc4 == "96") {
                                            $itemexl .= "^^" . $op5;
                                        }
                                    }
                                    if ($soc5 == "96") {
                                        $itemexl .= "^^" . $op5;
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($itemListData["KindA"] == "6" && $itemListData["KindB"] == "76") {
                        $gradeOptionsData = $this->loadGradeOptForItem();
                        $pentagramAttrData = $this->loadPentagramOptForWings();
                        if ($soc1 != 255) {
                            $op1 = $this->detect4thWingsExcOpt($gradeOptionsData, $soc1);
                            $itemexl .= "^^" . $op1;
                        }
                        if ($soc2 != 255) {
                            $op2 = $this->detect4thWingsExcOpt($gradeOptionsData, $soc2);
                            $itemexl .= "^^" . $op2;
                        }
                        if ($soc3 != 255) {
                            $op3 = $this->detect4thWingsExcOpt($gradeOptionsData, $soc3);
                            $itemexl .= "^^" . $op3;
                        }
                        if ($soc4 != 255) {
                            $op4 = $this->detect4thWingsExcOpt($gradeOptionsData, $soc4);
                            $itemexl .= "^^" . $op4;
                        }
                        if ($fullHarmony != 255) {
                            $mainOp = $this->detect4thWingsMainElemOpt($pentagramAttrData["main"], $fullHarmony);
                            $sock .= "<div style=&quot;color: var(--item-color-socket-opt);&quot;>" . $mainOp . "</div>";
                        }
                        if ($soc5 != 255) {
                            $addOp = $this->detect4thWingsAdditionalElemOpt($pentagramAttrData["add"], $soc5);
                            $sock .= "<div style=&quot;color: var(--item-color-socket-opt);&quot;>" . $addOp . "</div>";
                        }
                    } else {
                        if ($soc1 == "9" || $soc1 == "10") {
                            $excOptIndex = 5;
                            $opx7 = $op10;
                        } else {
                            if ($soc1 == "8") {
                                $excOptIndex = 4;
                                $opx7 = $op9;
                            } else {
                                if ($soc1 == "7") {
                                    $excOptIndex = 3;
                                    $opx7 = $op8;
                                } else {
                                    $opx7 = $op7;
                                    if ($itemListData["KindA"] == "14") {
                                        $excOptIndex = 4;
                                    } else {
                                        if ($itemListData["KindA"] == "15" || $itemListData["KindA"] == "18") {
                                            $excOptIndex = 2;
                                        } else {
                                            $excOptIndex = 6;
                                        }
                                    }
                                }
                            }
                        }
                        if ($availableExcOpts[$excOptIndex]["FormulaID"] != "-1" && "0" <= $availableExcOpts[$excOptIndex]["FormulaID"]) {
                            $formulaData = $this->loadExcOptFormula($availableExcOpts[$excOptIndex]["FormulaID"]);
                            $optValue = $this->calculateValueByFormula($availableExcOpts[$excOptIndex]["FormulaID"], $formulaData["Data"], $itemListData["DropLevel"]);
                        } else {
                            $optValue = $availableExcOpts[$excOptIndex]["Value"];
                        }
                        if ($availableExcOpts[$excOptIndex] != NULL && $availableExcOpts[$excOptIndex]["ID"] != "1" && $availableExcOpts[$excOptIndex]["ID"] != "2" && $availableExcOpts[$excOptIndex]["ID"] != "6" && $availableExcOpts[$excOptIndex]["ID"] != "7" && $availableExcOpts[$excOptIndex]["ID"] != "18") {
                            $op7 = sprintf($opx7, $optValue);
                        } else {
                            if ($itemtype == "5") {
                                $excOptStringTmp = lang("item_detail_txt_13", true);
                            } else {
                                $excOptStringTmp = lang("item_detail_txt_12", true);
                            }
                            if ($availableExcOpts[$excOptIndex]["ID"] == "1") {
                                $op7 = sprintf($opx7, $excOptStringTmp, $optValue);
                            } else {
                                if ($availableExcOpts[$excOptIndex]["ID"] == "2") {
                                    $op7 = sprintf($opx7, $excOptStringTmp, $optValue);
                                } else {
                                    if ($availableExcOpts[$excOptIndex]["ID"] == "6") {
                                        $op7 = sprintf($opx7, $excOptStringTmp, $optValue);
                                    } else {
                                        if ($availableExcOpts[$excOptIndex]["ID"] == "7") {
                                            $op7 = sprintf($opx7, $excOptStringTmp, $optValue);
                                        } else {
                                            if ($availableExcOpts[$excOptIndex]["ID"] == "18") {
                                                $op7 = sprintf($opx7, lang("item_detail_txt_17", true), $optValue);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if ($is_excopt_sx_1 == 1) {
                            $itemexl .= "^^" . $op7;
                        }
                        if ($soc2 == "9" || $soc2 == "10") {
                            $excOptIndex = 5;
                            $opx8 = $op10;
                        } else {
                            if ($soc2 == "8") {
                                $excOptIndex = 4;
                                $opx8 = $op9;
                            } else {
                                $opx8 = $op8;
                                if ($itemListData["KindA"] == "14") {
                                    $excOptIndex = 5;
                                } else {
                                    if ($itemListData["KindA"] == "15" || $itemListData["KindA"] == "18") {
                                        $excOptIndex = 3;
                                    } else {
                                        $excOptIndex = 7;
                                    }
                                }
                            }
                        }
                        if ($availableExcOpts[$excOptIndex]["FormulaID"] != "-1" && "0" <= $availableExcOpts[$excOptIndex]["FormulaID"]) {
                            $formulaData = $this->loadExcOptFormula($availableExcOpts[$excOptIndex]["FormulaID"]);
                            $optValue = $this->calculateValueByFormula($availableExcOpts[$excOptIndex]["FormulaID"], $formulaData["Data"], $itemListData["DropLevel"]);
                        } else {
                            $optValue = $availableExcOpts[$excOptIndex]["Value"];
                        }
                        if ($availableExcOpts[$excOptIndex] != NULL && $availableExcOpts[$excOptIndex]["ID"] != "1" && $availableExcOpts[$excOptIndex]["ID"] != "2" && $availableExcOpts[$excOptIndex]["ID"] != "6" && $availableExcOpts[$excOptIndex]["ID"] != "7" && $availableExcOpts[$excOptIndex]["ID"] != "18") {
                            $op8 = sprintf($opx8, $optValue);
                        } else {
                            if ($itemtype == "5") {
                                $excOptStringTmp = lang("item_detail_txt_13", true);
                            } else {
                                $excOptStringTmp = lang("item_detail_txt_12", true);
                            }
                            if ($availableExcOpts[$excOptIndex]["ID"] == "1") {
                                $op8 = sprintf($opx8, $excOptStringTmp, $optValue);
                            } else {
                                if ($availableExcOpts[$excOptIndex]["ID"] == "2") {
                                    $op8 = sprintf($opx8, $excOptStringTmp, $optValue);
                                } else {
                                    if ($availableExcOpts[$excOptIndex]["ID"] == "6") {
                                        $op8 = sprintf($opx8, $excOptStringTmp, $optValue);
                                    } else {
                                        if ($availableExcOpts[$excOptIndex]["ID"] == "7") {
                                            $op8 = sprintf($opx8, $excOptStringTmp, $optValue);
                                        } else {
                                            if ($availableExcOpts[$excOptIndex]["ID"] == "18") {
                                                $op8 = sprintf($opx8, lang("item_detail_txt_17", true), $optValue);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if ($is_excopt_sx_2 == 1) {
                            $itemexl .= "^^" . $op8;
                        }
                        if ($soc3 == "9" || $soc3 == "10") {
                            $excOptIndex = 5;
                            $opx9 = $op10;
                        } else {
                            $opx9 = $op9;
                            if ($itemListData["KindA"] == "15" || $itemListData["KindA"] == "18") {
                                $excOptIndex = 4;
                            } else {
                                $excOptIndex = 8;
                            }
                        }
                        if ($availableExcOpts[$excOptIndex]["FormulaID"] != "-1" && "0" <= $availableExcOpts[$excOptIndex]["FormulaID"]) {
                            $formulaData = $this->loadExcOptFormula($availableExcOpts[$excOptIndex]["FormulaID"]);
                            $optValue = $this->calculateValueByFormula($availableExcOpts[$excOptIndex]["FormulaID"], $formulaData["Data"], $itemListData["DropLevel"]);
                        } else {
                            $optValue = $availableExcOpts[$excOptIndex]["Value"];
                        }
                        if ($availableExcOpts[$excOptIndex] != NULL && $availableExcOpts[$excOptIndex]["ID"] != "1" && $availableExcOpts[$excOptIndex]["ID"] != "2" && $availableExcOpts[$excOptIndex]["ID"] != "6" && $availableExcOpts[$excOptIndex]["ID"] != "7" && $availableExcOpts[$excOptIndex]["ID"] != "18") {
                            $op9 = sprintf($opx9, $optValue);
                        } else {
                            if ($itemtype == "5") {
                                $excOptStringTmp = lang("item_detail_txt_13", true);
                            } else {
                                $excOptStringTmp = lang("item_detail_txt_12", true);
                            }
                            if ($availableExcOpts[$excOptIndex]["ID"] == "1") {
                                $op9 = sprintf($opx9, $excOptStringTmp, $optValue);
                            } else {
                                if ($availableExcOpts[$excOptIndex]["ID"] == "2") {
                                    $op9 = sprintf($opx9, $excOptStringTmp, $optValue);
                                } else {
                                    if ($availableExcOpts[$excOptIndex]["ID"] == "6") {
                                        $op9 = sprintf($opx9, $excOptStringTmp, $optValue);
                                    } else {
                                        if ($availableExcOpts[$excOptIndex]["ID"] == "7") {
                                            $op9 = sprintf($opx9, $excOptStringTmp, $optValue);
                                        } else {
                                            if ($availableExcOpts[$excOptIndex]["ID"] == "18") {
                                                $op9 = sprintf($opx9, lang("item_detail_txt_17", true), $optValue);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if ($is_excopt_sx_3 == 1) {
                            $itemexl .= "^^" . $op9;
                        }
                        if ($itemListData["KindA"] == "15" || $itemListData["KindA"] == "18") {
                            $excOptIndex = 5;
                        } else {
                            $excOptIndex = 9;
                        }
                        if ($availableExcOpts[$excOptIndex]["FormulaID"] != "-1" && "0" <= $availableExcOpts[$excOptIndex]["FormulaID"]) {
                            $formulaData = $this->loadExcOptFormula($availableExcOpts[$excOptIndex]["FormulaID"]);
                            $optValue = $this->calculateValueByFormula($availableExcOpts[$excOptIndex]["FormulaID"], $formulaData["Data"], $itemListData["DropLevel"]);
                        } else {
                            $optValue = $availableExcOpts[$excOptIndex]["Value"];
                        }
                        if ($availableExcOpts[$excOptIndex] != NULL && $availableExcOpts[$excOptIndex]["ID"] != "1" && $availableExcOpts[$excOptIndex]["ID"] != "2" && $availableExcOpts[$excOptIndex]["ID"] != "6" && $availableExcOpts[$excOptIndex]["ID"] != "7" && $availableExcOpts[$excOptIndex]["ID"] != "18") {
                            $op10 = sprintf($op10, $optValue);
                        } else {
                            if ($itemtype == "5") {
                                $excOptStringTmp = lang("item_detail_txt_13", true);
                            } else {
                                $excOptStringTmp = lang("item_detail_txt_12", true);
                            }
                            if ($availableExcOpts[$excOptIndex]["ID"] == "1") {
                                $op10 = sprintf($op10, $excOptStringTmp, $optValue);
                            } else {
                                if ($availableExcOpts[$excOptIndex]["ID"] == "2") {
                                    $op10 = sprintf($op10, $excOptStringTmp, $optValue);
                                } else {
                                    if ($availableExcOpts[$excOptIndex]["ID"] == "6") {
                                        $op10 = sprintf($op10, $excOptStringTmp, $optValue);
                                    } else {
                                        if ($availableExcOpts[$excOptIndex]["ID"] == "7") {
                                            $op10 = sprintf($op10, $excOptStringTmp, $optValue);
                                        } else {
                                            if ($availableExcOpts[$excOptIndex]["ID"] == "18") {
                                                $op10 = sprintf($op10, lang("item_detail_txt_17", true), $optValue);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if ($is_excopt_sx_4 == 1) {
                            $itemexl .= "^^" . $op10;
                        }
                    }
                }
            } else {
                if ($iopx1 == 1) {
                    $itemexl .= "^^" . $op1;
                }
                if ($iopx2 == 1) {
                    $itemexl .= "^^" . $op2;
                }
                if ($iopx3 == 1) {
                    $itemexl .= "^^" . $op3;
                }
                if ($iopx4 == 1) {
                    $itemexl .= "^^" . $op4;
                }
                if ($iopx5 == 1) {
                    $itemexl .= "^^" . $op5;
                }
                if ($iopx6 == 1) {
                    $itemexl .= "^^" . $op6;
                }
            }
        }
        if ($fresult["option"] == 4) {
            $itemoption = $iop . "%";
            $inf = lang("market_txt_51", true) . " ";
        } else {
            if ($fresult["option"] == 3) {
                $itemoption = $iop * 5;
                $inf = lang("market_txt_52", true) . " ";
            } else {
                $itemoption = $iop * 4;
            }
        }
        $c = "var(--item-color-normal)";
        if (1 < $iop || $luck != "") {
            $c = "var(--item-color-life-opt)";
        }
        if (6 < $itemlevel) {
            $c = "var(--item-color-improved)";
        }
        $tipche = 0;
        if ($itemexl != "") {
            $c = "var(--item-color-exc)";
            $tipche = 1;
        }
        if ($itemtype == 12) {
            if ($sy == 1 || $sy == 41) {
                $itemoption = $iop * 4;
                $inf = lang("market_txt_203", true) . " ";
            } else {
                if ($sy == 2) {
                    $itemoption = $iop * 4;
                    $inf = lang("market_txt_26", true) . " ";
                } else {
                    if ($sy == 0) {
                        $itemoption = $iop . "%";
                        $inf = lang("market_txt_51", true) . " ";
                    } else {
                        if ($sy == 4) {
                            if ($lifeOptType == 1) {
                                $itemoption = $iop . "%";
                                $inf = lang("market_txt_51", true) . " ";
                            } else {
                                if ($lifeOptType == 2) {
                                    $itemoption = $iop * 4;
                                    $inf = lang("market_txt_203", true) . " ";
                                }
                            }
                        } else {
                            if ($sy == 5 || $sy == 49 || $sy == 269 || $sy == 262 || $sy == 263 || $sy == 265) {
                                if ($lifeOptType == 1) {
                                    $itemoption = $iop . "%";
                                    $inf = lang("market_txt_51", true) . " ";
                                } else {
                                    if ($lifeOptType == 2) {
                                        $itemoption = $iop * 4;
                                        $inf = lang("market_txt_26", true) . " ";
                                    }
                                }
                            } else {
                                if ($sy == 3) {
                                    if ($lifeOptType == 1) {
                                        $itemoption = $iop * 4;
                                        $inf = lang("market_txt_26", true) . " ";
                                    } else {
                                        if ($lifeOptType == 2) {
                                            $itemoption = $iop . "%";
                                            $inf = lang("market_txt_51", true) . " ";
                                        }
                                    }
                                } else {
                                    if ($sy == 6) {
                                        if ($lifeOptType == 1) {
                                            $itemoption = $iop * 4;
                                            $inf = lang("market_txt_203", true) . " ";
                                        } else {
                                            if ($lifeOptType == 2) {
                                                $itemoption = $iop * 4;
                                                $inf = lang("market_txt_26", true) . " ";
                                            }
                                        }
                                    } else {
                                        if ($sy == 42 || $sy == 264) {
                                            if ($lifeOptType == 1) {
                                                $itemoption = $iop * 4;
                                                $inf = lang("market_txt_204", true) . " ";
                                            } else {
                                                if ($lifeOptType == 2) {
                                                    $itemoption = $iop * 4;
                                                    $inf = lang("market_txt_203", true) . " ";
                                                }
                                            }
                                        } else {
                                            if ($sy == 37 || $sy == 414) {
                                                if ($lifeOptType == 1) {
                                                    $itemoption = $iop . "%";
                                                    $inf = lang("market_txt_51", true) . " ";
                                                } else {
                                                    if ($lifeOptType == 2) {
                                                        $itemoption = $iop * 4;
                                                        $inf = lang("market_txt_52", true) . " ";
                                                    } else {
                                                        if ($lifeOptType == 3) {
                                                            $itemoption = $iop * 4;
                                                            $inf = lang("market_txt_203", true) . " ";
                                                        }
                                                    }
                                                }
                                            } else {
                                                if ($sy == 36 || $sy == 38 || $sy == 40 || $sy == 50 || $sy == 270 || $sy == 415 || $sy == 416 || $sy == 418 || $sy == 420 || $sy == 421) {
                                                    if ($lifeOptType == 1) {
                                                        $itemoption = $iop . "%";
                                                        $inf = lang("market_txt_51", true) . " ";
                                                    } else {
                                                        if ($lifeOptType == 2) {
                                                            $itemoption = $iop * 4;
                                                            $inf = lang("market_txt_52", true) . " ";
                                                        } else {
                                                            if ($lifeOptType == 3) {
                                                                $itemoption = $iop * 4;
                                                                $inf = lang("market_txt_26", true) . " ";
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    if ($sy == 39 || $sy == 417) {
                                                        if ($lifeOptType == 1) {
                                                            $itemoption = $iop . "%";
                                                            $inf = lang("market_txt_51", true) . " ";
                                                        } else {
                                                            if ($lifeOptType == 2) {
                                                                $itemoption = $iop * 4;
                                                                $inf = lang("market_txt_203", true) . " ";
                                                            } else {
                                                                if ($lifeOptType == 3) {
                                                                    $itemoption = $iop * 4;
                                                                    $inf = lang("market_txt_26", true) . " ";
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        if ($sy == 43 || $sy == 419) {
                                                            if ($lifeOptType == 1) {
                                                                $itemoption = $iop . "%";
                                                                $inf = lang("market_txt_51", true) . " ";
                                                            } else {
                                                                if ($lifeOptType == 2) {
                                                                    $itemoption = $iop * 4;
                                                                    $inf = lang("market_txt_204", true) . " ";
                                                                } else {
                                                                    if ($lifeOptType == 3) {
                                                                        $itemoption = $iop * 4;
                                                                        $inf = lang("market_txt_203", true) . " ";
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            if ($sy == 267) {
                                                                $inf = "";
                                                            } else {
                                                                if ($sy == 266) {
                                                                    $itemoption = $iop . "%";
                                                                    $inf = lang("market_txt_51", true) . " ";
                                                                } else {
                                                                    if ($sy == 268) {
                                                                        if ($lifeOptType == 1) {
                                                                            $itemoption = $iop . "%";
                                                                            $inf = lang("market_txt_51", true) . " ";
                                                                        } else {
                                                                            if ($lifeOptType == 2) {
                                                                                $itemoption = $iop * 4;
                                                                                $inf = lang("market_txt_26", true) . " ";
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
            }
        } else {
            if ($itemtype == 13 && $sy == 30) {
                $itemoption = $iop * 4;
                $inf = lang("market_txt_26", true) . " ";
            }
        }
        $opt2 = $iop;
        if ($fresult["purple"] == 1) {
            $c = "var(--item-color-socket)";
        }
        if ($itemoption == 0) {
            $itemoption = "";
        } else {
            $itemoption = $inf . " +" . $itemoption;
        }
        if ($itemexl != "") {
            $incrall = 20;
        }
        if (0 < $ac && $itemListData["Type"] != "2") {
            $c = "var(--item-color-exc)";
            $ancias = "style=&quot;background:var(--item-color-anc)&quot;";
            $ancia = "var(--item-color-anc)";
            $ancsetopt = "";
            $ancSetId = NULL;
            $ancData = $dB->query_fetch_single("SELECT * FROM [IMPERIAMUCMS_DATA_ANCIENT_ITEMS] WHERE [item_id] = ? AND [item_cat] = ?", [$sy, $itemtype]);
            if ($ancTier == 1) {
                $ancOptData = $dB->query_fetch_single("SELECT * FROM [IMPERIAMUCMS_DATA_ANCIENT_SETS] WHERE ancient_id = ?", [$ancData["tier1"]]);
                $ancSetId = $ancData["tier1"];
            } else {
                if ($ancTier == 2) {
                    $ancOptData = $dB->query_fetch_single("SELECT * FROM [IMPERIAMUCMS_DATA_ANCIENT_SETS] WHERE ancient_id = ?", [$ancData["tier2"]]);
                    $ancSetId = $ancData["tier2"];
                }
            }
            $itemname = $ancOptData["ancient_name"] . " " . $itemname . "";
            if ($itemoption) {
                $itemoption .= "<br>";
            }
            if (78 <= $ancSetId && $ancSetId <= 92 || 110 <= $ancSetId && $ancSetId <= 141) {
                if ($ac_sta == 5) {
                    $ac_sta = 7;
                } else {
                    if ($ac_sta == 10) {
                        $ac_sta = 15;
                    }
                }
                $itemoption .= lang("anc_opt_name", true) . ": " . sprintf(lang("anc_opt_bonus_1", true), $ac_sta);
            } else {
                $itemoption .= lang("anc_opt_name", true) . ": +" . $ac_sta . " " . lang("market_txt_53", true);
            }
            $ancOpts = explode(";", $ancOptData["ancient_opt_lang"]);
            foreach ($ancOpts as $thisOpt) {
                $ancOptName = str_replace("'", "\\'", lang($thisOpt, true));
                $ancsetopt .= "<br>" . $ancOptName;
            }
            $ancsetopt = "<span style=&quot;color: var(--item-color-anc-setopt);&quot;>" . lang("anc_opt_title", true) . "</span>" . $ancsetopt;
            $tipche = 2;
        }
        if ($nocolor) {
            $c = "var(--item-color-nocolor)";
        }
        if ($fresult["type"] == 13 && $fresult["id"] == 37) {
            $skill = lang("market_txt_54", true);
            $c = "var(--item-color-fenrir)";
            if ($iopx1 == 1) {
                $itemname .= " " . lang("market_txt_55", true);
                $itemoption = lang("market_txt_58", true);
                $itemexl = "";
            } else {
                if ($iopx2 == 1) {
                    $itemname .= " " . lang("market_txt_56", true);
                    $itemoption = lang("market_txt_59", true);
                    $itemexl = "";
                } else {
                    if ($iopx3 == 1) {
                        $itemname = "<span style=&quot;color: var(--item-color-fenrir-gold);&quot;>" . lang("market_txt_57", true) . "</span>";
                        $itemoption = lang("market_txt_60", true);
                        $itemexl = "";
                    }
                }
            }
        } else {
            if (!$nocolor && $itemexl != "" && $itemname && $ac == 0) {
                $itemname = lang("market_txt_61", true) . " " . $itemname;
            }
        }
        if ($nolevel == 1) {
            $ilvl = 0;
        } else {
            $ilvl = $itemlevel;
        }
        if ($fresult["id"] == 10 && $fresult["type"] == 13) {
            if ($itemlevel == 0) {
                $itemname = lang("market_txt_62", true);
            } else {
                if ($itemlevel == 1) {
                    $itemname = lang("market_txt_63", true);
                } else {
                    if ($itemlevel == 2) {
                        $itemname = lang("market_txt_64", true);
                    } else {
                        if ($itemlevel == 3) {
                            $itemname = lang("market_txt_65", true);
                        } else {
                            if ($itemlevel == 4) {
                                $itemname = lang("market_txt_66", true);
                            } else {
                                if ($itemlevel == 5) {
                                    $itemname = lang("market_txt_67", true);
                                }
                            }
                        }
                    }
                }
            }
        }
        $elemental_id[0] = substr($socket, 0, 2);
        $elemental_id[1] = substr($socket, 2, 2);
        $elemental_id[2] = substr($socket, 4, 2);
        $elemental_id[3] = substr($socket, 6, 2);
        $elemental_id[4] = substr($socket, 8, 2);
        if ($itemListData["KindA"] == "8" && $itemListData["KindB"] == "44") {
            if ($harmlvl == "1") {
                $itemoption = "<span style=&quot;color: var(--item-color-errtel1);&quot;>" . lang("market_txt_68", true) . "</span><br>";
            }
            if ($harmlvl == "2") {
                $itemoption = "<span style=&quot;color: var(--item-color-errtel2);&quot;>" . lang("market_txt_69", true) . "</span><br>";
            }
            if ($harmlvl == "3") {
                $itemoption = "<span style=&quot;color: var(--item-color-errtel3);&quot;>" . lang("market_txt_70", true) . "</span><br>";
            }
            if ($harmlvl == "4") {
                $itemoption = "<span style=&quot;color: var(--item-color-errtel4);&quot;>" . lang("market_txt_71", true) . "</span><br>";
            }
            if ($harmlvl == "5") {
                $itemoption = "<span style=&quot;color: var(--item-color-errtel5);&quot;>" . lang("market_txt_72", true) . "</span><br>";
            }
            $errtelI = 0;
            while ($errtelI < 5) {
                $elemental_rank[$errtelI] = substr($elemental_id[$errtelI], 1);
                $elemental_level[$errtelI] = substr($elemental_id[$errtelI], 0, -1);
                $elemental_level[$errtelI] = $elemental_level[$errtelI] == "A" ? "10" : $elemental_level[$errtelI];
                if ($elemental_id[$errtelI] != "FF") {
                    $elemental_count++;
                    $errtel_id = $errtelI + 1;
                    $itemoption .= "<br><span>" . $errtel_id . " Rank Option +" . $elemental_level[$errtelI] . "</span><br>" . $this->errtel($fresult["id"], $errtel_id, $elemental_rank[$errtelI], $elemental_level[$errtelI]) . "<br>";
                }
                $errtelI++;
            }
        }
        if ($itemListData["KindA"] == "8" && $itemListData["KindB"] == "43") {
            if ($harmlvl == "1") {
                $itemoption = "<span style=&quot;color: var(--item-color-errtel1);&quot;>" . lang("market_txt_68", true) . "</span><br>";
            }
            if ($harmlvl == "2") {
                $itemoption = "<span style=&quot;color: var(--item-color-errtel2);&quot;>" . lang("market_txt_69", true) . "</span><br>";
            }
            if ($harmlvl == "3") {
                $itemoption = "<span style=&quot;color: var(--item-color-errtel3);&quot;>" . lang("market_txt_70", true) . "</span><br>";
            }
            if ($harmlvl == "4") {
                $itemoption = "<span style=&quot;color: var(--item-color-errtel4);&quot;>" . lang("market_txt_71", true) . "</span><br>";
            }
            if ($harmlvl == "5") {
                $itemoption = "<span style=&quot;color: var(--item-color-errtel5);&quot;>" . lang("market_txt_72", true) . "</span><br>";
            }
            if ($_GET["subpage"] == "market") {
                $getUsername = $dB->query_fetch_single("SELECT seller FROM IMPERIAMUCMS_MARKET WHERE item = ?", [$_item]);
                $owner = $getUsername["seller"];
            } else {
                $owner = $_SESSION["username"];
            }
            if ($_GET["page"] == "admincp") {
                $owner = $username;
            }
            if ($soc1 != 255) {
                $itemoption .= "<br><span style=&quot;color: var(--item-color-errtel-title);&quot;>" . lang("market_txt_73", true) . "</span>";
                if ($soc1 != 254) {
                    if (140 <= config("server_files_season", true)) {
                        $pentagramData = $this->getPentagramData($username, $charName, $location, $soc1);
                    } else {
                        $pentagramData = $dB->query_fetch_single("SELECT * FROM T_PentagramInfo WHERE JewelIndex = ? AND AccountID = ?", [$soc1, $owner]);
                    }
                    $errtelRank = 0;
                    if ($pentagramData["Rank1"] < 15 && 0 < $pentagramData["Rank1"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank2"] < 15 && 0 < $pentagramData["Rank2"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank3"] < 15 && 0 < $pentagramData["Rank3"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank4"] < 15 && 0 < $pentagramData["Rank4"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank5"] < 15 && 0 < $pentagramData["Rank5"]) {
                        $errtelRank++;
                    }
                    $i = 1;
                    while ($i <= $errtelRank) {
                        $errtelData = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_DATA_ERRTELS WHERE errtel_rank = ? AND item_type = ? AND item_index = ?", [$i, $pentagramData["ItemType"], $pentagramData["ItemIndex"]]);
                        $count = 1;
                        foreach ($errtelData as $thisErrtel) {
                            if ($pentagramData["Rank" . $i] == $count) {
                                $errtelOption = sprintf(addslashes(lang($thisErrtel["errtel_option_lang"], true)), $thisErrtel["errtel_level_" . $pentagramData["Rank" . $i . "Level"]]);
                            }
                            $count++;
                        }
                        $itemoption .= "<br><span style=&quot;color: var(--item-color-errtel-opt);&quot;>" . $errtelOption . "</span>";
                        $i++;
                    }
                } else {
                    $itemoption .= "<br><span style=&quot;color: var(--item-color-errtel-opt);&quot;>" . lang("market_txt_78", true) . "</span>";
                }
            }
            if ($soc2 != 255) {
                $itemoption .= "<br><br><span style=&quot;color: var(--item-color-errtel-title);&quot;>" . lang("market_txt_74", true) . "</span>";
                if ($soc2 != 254) {
                    if (140 <= config("server_files_season", true)) {
                        $pentagramData = $this->getPentagramData($username, $charName, $location, $soc2);
                    } else {
                        $pentagramData = $dB->query_fetch_single("SELECT * FROM T_PentagramInfo WHERE JewelIndex = ? AND AccountID = ?", [$soc2, $owner]);
                    }
                    $errtelRank = 0;
                    if ($pentagramData["Rank1"] < 15 && 0 < $pentagramData["Rank1"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank2"] < 15 && 0 < $pentagramData["Rank2"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank3"] < 15 && 0 < $pentagramData["Rank3"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank4"] < 15 && 0 < $pentagramData["Rank4"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank5"] < 15 && 0 < $pentagramData["Rank5"]) {
                        $errtelRank++;
                    }
                    $i = 1;
                    while ($i <= $errtelRank) {
                        $errtelData = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_DATA_ERRTELS WHERE errtel_rank = ? AND item_type = ? AND item_index = ?", [$i, $pentagramData["ItemType"], $pentagramData["ItemIndex"]]);
                        $count = 1;
                        foreach ($errtelData as $thisErrtel) {
                            if ($pentagramData["Rank" . $i] == $count) {
                                $errtelOption = sprintf(addslashes(lang($thisErrtel["errtel_option_lang"], true)), $thisErrtel["errtel_level_" . $pentagramData["Rank" . $i . "Level"]]);
                            }
                            $count++;
                        }
                        $itemoption .= "<br><span style=&quot;color: var(--item-color-errtel-opt);&quot;>" . $errtelOption . "</span>";
                        $i++;
                    }
                } else {
                    $itemoption .= "<br><span style=&quot;color: var(--item-color-errtel-opt);&quot;>" . lang("market_txt_78", true) . "</span>";
                }
            }
            if ($soc3 != 255) {
                $itemoption .= "<br><br><span style=&quot;color: var(--item-color-errtel-title);&quot;>" . lang("market_txt_75", true) . "</span>";
                if ($soc3 != 254) {
                    if (140 <= config("server_files_season", true)) {
                        $pentagramData = $this->getPentagramData($username, $charName, $location, $soc3);
                    } else {
                        $pentagramData = $dB->query_fetch_single("SELECT * FROM T_PentagramInfo WHERE JewelIndex = ? AND AccountID = ?", [$soc3, $owner]);
                    }
                    $errtelRank = 0;
                    if ($pentagramData["Rank1"] < 15 && 0 < $pentagramData["Rank1"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank2"] < 15 && 0 < $pentagramData["Rank2"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank3"] < 15 && 0 < $pentagramData["Rank3"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank4"] < 15 && 0 < $pentagramData["Rank4"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank5"] < 15 && 0 < $pentagramData["Rank5"]) {
                        $errtelRank++;
                    }
                    $i = 1;
                    while ($i <= $errtelRank) {
                        $errtelData = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_DATA_ERRTELS WHERE errtel_rank = ? AND item_type = ? AND item_index = ?", [$i, $pentagramData["ItemType"], $pentagramData["ItemIndex"]]);
                        $count = 1;
                        foreach ($errtelData as $thisErrtel) {
                            if ($pentagramData["Rank" . $i] == $count) {
                                $errtelOption = sprintf(addslashes(lang($thisErrtel["errtel_option_lang"], true)), $thisErrtel["errtel_level_" . $pentagramData["Rank" . $i . "Level"]]);
                            }
                            $count++;
                        }
                        $itemoption .= "<br><span style=&quot;color: var(--item-color-errtel-opt);&quot;>" . $errtelOption . "</span>";
                        $i++;
                    }
                } else {
                    $itemoption .= "<br><span style=&quot;color: var(--item-color-errtel-opt);&quot;>" . lang("market_txt_78", true) . "</span>";
                }
            }
            if ($soc4 != 255) {
                $itemoption .= "<br><br><span style=&quot;color: var(--item-color-errtel-title);&quot;>" . lang("market_txt_76", true) . "</span>";
                if ($soc4 != 254) {
                    if (140 <= config("server_files_season", true)) {
                        $pentagramData = $this->getPentagramData($username, $charName, $location, $soc4);
                    } else {
                        $pentagramData = $dB->query_fetch_single("SELECT * FROM T_PentagramInfo WHERE JewelIndex = ? AND AccountID = ?", [$soc4, $owner]);
                    }
                    $errtelRank = 0;
                    if ($pentagramData["Rank1"] < 15 && 0 < $pentagramData["Rank1"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank2"] < 15 && 0 < $pentagramData["Rank2"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank3"] < 15 && 0 < $pentagramData["Rank3"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank4"] < 15 && 0 < $pentagramData["Rank4"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank5"] < 15 && 0 < $pentagramData["Rank5"]) {
                        $errtelRank++;
                    }
                    $i = 1;
                    while ($i <= $errtelRank) {
                        $errtelData = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_DATA_ERRTELS WHERE errtel_rank = ? AND item_type = ? AND item_index = ?", [$i, $pentagramData["ItemType"], $pentagramData["ItemIndex"]]);
                        $count = 1;
                        foreach ($errtelData as $thisErrtel) {
                            if ($pentagramData["Rank" . $i] == $count) {
                                $errtelOption = sprintf(addslashes(lang($thisErrtel["errtel_option_lang"], true)), $thisErrtel["errtel_level_" . $pentagramData["Rank" . $i . "Level"]]);
                            }
                            $count++;
                        }
                        $itemoption .= "<br><span style=&quot;color: var(--item-color-errtel-opt);&quot;>" . $errtelOption . "</span>";
                        $i++;
                    }
                } else {
                    $itemoption .= "<br><span style=&quot;color: var(--item-color-errtel-opt);&quot;>" . lang("market_txt_78", true) . "</span>";
                }
            }
            if ($soc5 != 255) {
                $itemoption .= "<br><br><span style=&quot;color: var(--item-color-errtel-title);&quot;>" . lang("market_txt_77", true) . "</span>";
                if ($soc5 != 254) {
                    if (140 <= config("server_files_season", true)) {
                        $pentagramData = $this->getPentagramData($username, $charName, $location, $soc5);
                    } else {
                        $pentagramData = $dB->query_fetch_single("SELECT * FROM T_PentagramInfo WHERE JewelIndex = ? AND AccountID = ?", [$soc5, $owner]);
                    }
                    $errtelRank = 0;
                    if ($pentagramData["Rank1"] < 15 && 0 < $pentagramData["Rank1"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank2"] < 15 && 0 < $pentagramData["Rank2"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank3"] < 15 && 0 < $pentagramData["Rank3"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank4"] < 15 && 0 < $pentagramData["Rank4"]) {
                        $errtelRank++;
                    }
                    if ($pentagramData["Rank5"] < 15 && 0 < $pentagramData["Rank5"]) {
                        $errtelRank++;
                    }
                    $i = 1;
                    while ($i <= $errtelRank) {
                        $errtelData = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_DATA_ERRTELS WHERE errtel_rank = ? AND item_type = ? AND item_index = ?", [$i, $pentagramData["ItemType"], $pentagramData["ItemIndex"]]);
                        $count = 1;
                        foreach ($errtelData as $thisErrtel) {
                            if ($pentagramData["Rank" . $i] == $count) {
                                $errtelOption = sprintf(addslashes(lang($thisErrtel["errtel_option_lang"], true)), $thisErrtel["errtel_level_" . $pentagramData["Rank" . $i . "Level"]]);
                            }
                            $count++;
                        }
                        $itemoption .= "<br><span style=&quot;color: var(--item-color-errtel-opt);&quot;>" . $errtelOption . "</span>";
                        $i++;
                    }
                } else {
                    $itemoption .= "<br><span style=&quot;color: var(--item-color-errtel-opt);&quot;>" . lang("market_txt_78", true) . "</span>";
                }
            }
            $itemexl = "";
        }
        $itemDetails = "";
        $classReq = "";
        $dropLevel = $itemListData["DropLevel"];
        if ($iopx1 == 1 || $iopx2 == 1 || $iopx3 == 1 || $iopx4 == 1 || $iopx5 == 1 || $iopx6 == 1 || $is_excopt_sx_1 == 1 || $is_excopt_sx_2 == 1 || $is_excopt_sx_3 == 1 || $is_excopt_sx_4 == 1) {
            $isExc = 1;
            $easytoyou_decoder_beta_not_finish += 25;
        } else {
            $isExc = 0;
        }
        if (0 < $itemListData["DamageMin"] && 0 < $itemListData["DamageMax"]) {
            if ($isExc) {
                $minMaxDmgExc = floor($itemListData["DamageMin"] * 25 / $dropLevel + 5);
            }
            $mindmg = $ilvl * 3 + $itemListData["DamageMin"];
            $maxdmg = $ilvl * 3 + $itemListData["DamageMax"];
            if (10 <= $ilvl) {
                $mindmg += 1;
                $maxdmg += 1;
            }
            if (11 <= $ilvl) {
                $mindmg += 2;
                $maxdmg += 2;
            }
            if (12 <= $ilvl) {
                $mindmg += 3;
                $maxdmg += 3;
            }
            if (13 <= $ilvl) {
                $mindmg += 4;
                $maxdmg += 4;
            }
            if (14 <= $ilvl) {
                $mindmg += 5;
                $maxdmg += 5;
            }
            if (15 <= $ilvl) {
                $mindmg += 6;
                $maxdmg += 6;
            }
            if ($isExc) {
                $mindmg += $minMaxDmgExc;
                $maxdmg += $minMaxDmgExc;
            }
            if ($itemListData["TwoHand"] == "0") {
                $itemDetails .= "<br>" . sprintf(lang("item_detail_txt_4", true), $mindmg, $maxdmg);
            } else {
                $itemDetails .= "<br>" . sprintf(lang("item_detail_txt_5", true), $mindmg, $maxdmg);
            }
        }
        if (0 < $itemListData["Defense"]) {
            if ($isExc) {
                $defenseExc = floor($itemListData["Defense"] * 12 / $dropLevel + $dropLevel / 5 + 4);
            }
            $defense = $ilvl * 3 + $itemListData["Defense"];
            if (10 <= $ilvl) {
                $defense += 1;
            }
            if (11 <= $ilvl) {
                $defense += 2;
            }
            if (12 <= $ilvl) {
                $defense += 3;
            }
            if (13 <= $ilvl) {
                $defense += 4;
            }
            if (14 <= $ilvl) {
                $defense += 5;
            }
            if (15 <= $ilvl) {
                $defense += 6;
            }
            if ($isExc) {
                $defense += $defenseExc;
            }
            $itemDetails .= "<br>" . sprintf(lang("item_detail_txt_1", true), $defense);
        }
        if (0 < $itemListData["AttackSpeed"]) {
            $itemDetails .= "<br>" . sprintf(lang("item_detail_txt_2", true), $itemListData["AttackSpeed"]);
        }
        if (0 < $itemListData["Durability"]) {
            if ($itemtype == 14 && $sy == 21 && $ilvl == 3) {
                $itemLevelTmp = 0;
            } else {
                $itemLevelTmp = $ilvl;
            }
            $maxDur = 0;
            if ($itemtype == 14 && $sy == 29 || $itemtype == 14 && $sy == 100 || $itemtype == 14 && $sy == 101 || $itemtype == 14 && $sy == 110 || $itemtype == 14 && $sy == 153 || $itemtype == 14 && $sy == 154 || $itemtype == 14 && $sy == 155 || $itemtype == 14 && $sy == 156) {
                $maxDur = 1;
            } else {
                if ($itemLevelTmp < 5) {
                    $maxDur = $itemListData["Durability"] + $itemLevelTmp;
                } else {
                    if (5 <= $itemLevelTmp) {
                        if ($itemLevelTmp == 10) {
                            $maxDur = $itemListData["Durability"] + $itemLevelTmp * 2 - 3;
                        } else {
                            if ($itemLevelTmp == 11) {
                                $maxDur = $itemListData["Durability"] + $itemLevelTmp * 2 - 1;
                            } else {
                                if ($itemLevelTmp == 12) {
                                    $maxDur = $itemListData["Durability"] + $itemLevelTmp * 2 + 2;
                                } else {
                                    if ($itemLevelTmp == 13) {
                                        $maxDur = $itemListData["Durability"] + $itemLevelTmp * 2 + 6;
                                    } else {
                                        if ($itemLevelTmp == 14) {
                                            $maxDur = $itemListData["Durability"] + $itemLevelTmp * 2 + 11;
                                        } else {
                                            if ($itemLevelTmp == 15) {
                                                $maxDur = $itemListData["Durability"] + $itemLevelTmp * 2 + 17;
                                            } else {
                                                $maxDur = $itemListData["Durability"] + $itemLevelTmp * 2 - 4;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if (0 < $ac) {
                    $maxDur += 20;
                }
                if ($isExc == 1) {
                    $maxDur += 15;
                }
            }
            if (255 < $maxDur) {
                $maxDur = 255;
            }
            if ($itemListData["Slot"] != "-1") {
                if ($itemListData["KindA"] == "8" && $itemListData["KindB"] == "43") {
                    $maxDur = $itemListData["Durability"];
                    $itemDetails .= "<br>" . sprintf(lang("item_detail_txt_15", true), "[" . $itemdur . "/" . $maxDur . "]");
                } else {
                    $itemDetails .= "<br>" . sprintf(lang("item_detail_txt_14", true), "[" . $itemdur . "/" . $maxDur . "]");
                }
            }
        } else {
            if (0 < $itemdur) {
                $itemDetails .= "<br>" . sprintf(lang("item_detail_txt_14", true), $itemdur);
            }
        }
        if (0 < $itemListData["ReqLevel"]) {
            $levelRatio = 0;
            if ($itemListData["KindA"] == "6") {
                if ($itemListData["KindB"] == "23" || $itemListData["KindB"] == "26" || $itemListData["KindB"] == "27" || $itemListData["KindB"] == "28") {
                    $levelRatio = 4;
                } else {
                    if ($itemListData["KindB"] == "24") {
                        $levelRatio = 5;
                    }
                }
            } else {
                if ($itemListData["KindA"] == "8" && $itemListData["KindB"] == "43") {
                    $levelRatio = 4;
                }
            }
            $reqLevel = $itemListData["ReqLevel"] + $levelRatio * $ilvl;
            $itemDetails .= "<br>" . sprintf(lang("item_detail_txt_3", true), $reqLevel);
        }
        if (0 < $itemListData["ReqStrength"]) {
            $reqStr = $itemListData["ReqStrength"] * ($itemListData["DropLevel"] + $ilvl * 3) * 3 / 100 + 20;
            $itemDetails .= "<br>" . sprintf(lang("item_detail_txt_7", true), $reqStr);
        }
        if (0 < $itemListData["ReqDexterity"]) {
            $reqAgi = $itemListData["ReqDexterity"] * ($itemListData["DropLevel"] + $ilvl * 3) * 3 / 100 + 20;
            $itemDetails .= "<br>" . sprintf(lang("item_detail_txt_8", true), $reqAgi);
        }
        if (0 < $itemListData["ReqVitality"]) {
            $reqVit = $itemListData["ReqVitality"] * ($itemListData["DropLevel"] + $ilvl * 3) * 3 / 100 + 20;
            $itemDetails .= "<br>" . sprintf(lang("item_detail_txt_9", true), $reqVit);
        }
        if (0 < $itemListData["ReqEnergy"]) {
            $reqEne = $itemListData["ReqEnergy"] * ($itemListData["DropLevel"] + $ilvl * 3) * 3 / 100 + 20;
            $itemDetails .= "<br>" . sprintf(lang("item_detail_txt_10", true), $reqEne);
        }
        if (0 < $itemListData["ReqCommand"]) {
            $reqCmd = $itemListData["ReqCommand"] * ($itemListData["DropLevel"] + $ilvl * 3) * 3 / 100 + 20;
            $itemDetails .= "<br>" . sprintf(lang("item_detail_txt_11", true), $reqCmd);
        }
        if (131 <= config("server_files_season", true)) {
            $gmCode = 3;
            $bmCode = 19;
            $heCode = 35;
            $dsCode = 83;
        } else {
            $gmCode = 2;
            $bmCode = 18;
            $heCode = 34;
            $dsCode = 82;
        }
        if ($itemListData["DarkWizard"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][0][0]);
        } else {
            if ($itemListData["DarkWizard"] == "2") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][1][0]);
            } else {
                if ($itemListData["DarkWizard"] == "3") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][$gmCode][0]);
                } else {
                    if ($itemListData["DarkWizard"] == "4") {
                        $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][7][0]);
                    }
                }
            }
        }
        if ($itemListData["DarkKnight"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][16][0]);
        } else {
            if ($itemListData["DarkKnight"] == "2") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][17][0]);
            } else {
                if ($itemListData["DarkKnight"] == "3") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][$bmCode][0]);
                } else {
                    if ($itemListData["DarkKnight"] == "4") {
                        $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][23][0]);
                    }
                }
            }
        }
        if ($itemListData["FairyElf"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][32][0]);
        } else {
            if ($itemListData["FairyElf"] == "2") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][33][0]);
            } else {
                if ($itemListData["FairyElf"] == "3") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][$heCode][0]);
                } else {
                    if ($itemListData["FairyElf"] == "4") {
                        $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][39][0]);
                    }
                }
            }
        }
        if ($itemListData["MagicGladiator"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][48][0]);
        } else {
            if ($itemListData["MagicGladiator"] == "3") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][50][0]);
            } else {
                if ($itemListData["MagicGladiator"] == "4") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][54][0]);
                }
            }
        }
        if ($itemListData["DarkLord"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][64][0]);
        } else {
            if ($itemListData["DarkLord"] == "3") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][66][0]);
            } else {
                if ($itemListData["DarkLord"] == "4") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][70][0]);
                }
            }
        }
        if ($itemListData["Summoner"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][80][0]);
        } else {
            if ($itemListData["Summoner"] == "2") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][81][0]);
            } else {
                if ($itemListData["Summoner"] == "3") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][$dsCode][0]);
                } else {
                    if ($itemListData["Summoner"] == "4") {
                        $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][87][0]);
                    }
                }
            }
        }
        if ($itemListData["RageFighter"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][96][0]);
        } else {
            if ($itemListData["RageFighter"] == "3") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][98][0]);
            } else {
                if ($itemListData["RageFighter"] == "4") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][102][0]);
                }
            }
        }
        if ($itemListData["GrowLancer"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][112][0]);
        } else {
            if ($itemListData["GrowLancer"] == "3") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][114][0]);
            } else {
                if ($itemListData["GrowLancer"] == "4") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][118][0]);
                }
            }
        }
        if ($itemListData["RuneWizard"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][128][0]);
        } else {
            if ($itemListData["RuneWizard"] == "2") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][129][0]);
            } else {
                if ($itemListData["RuneWizard"] == "3") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][131][0]);
                } else {
                    if ($itemListData["RuneWizard"] == "4") {
                        $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][135][0]);
                    }
                }
            }
        }
        if ($itemListData["Slayer"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][144][0]);
        } else {
            if ($itemListData["Slayer"] == "2") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][145][0]);
            } else {
                if ($itemListData["Slayer"] == "3") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][147][0]);
                } else {
                    if ($itemListData["Slayer"] == "4") {
                        $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][151][0]);
                    }
                }
            }
        }
        if ("1" <= $itemListData["DarkWizard"] && "1" <= $itemListData["DarkKnight"] && "1" <= $itemListData["FairyElf"] && "1" <= $itemListData["MagicGladiator"] && "1" <= $itemListData["DarkLord"] && "1" <= $itemListData["Summoner"] && "1" <= $itemListData["RageFighter"] && "1" <= $itemListData["GrowLancer"] && "1" <= $itemListData["RuneWizard"]) {
            $classReq = "";
        }
        $output["sticklevel"] = $fresult["level"];
        $output["category"] = $fresult["type"];
        $output["type"] = $fresult["type"];
        $output["id"] = $fresult["id"];
        $output["name"] = $itemname;
        $output["level"] = $ilvl;
        $output["opt"] = $itemoption;
        $output["exl"] = $itemexl;
        $output["luck"] = $luck;
        $output["skill"] = $skill;
        $output["jog"] = $jogopt;
        $output["harm"] = $harmon;
        $output["socket"] = $sock;
        $output["dur"] = $itemdur;
        $output["anc"] = $ancias;
        $output["anco"] = $ancia;
        $output["X"] = $fresult["X"];
        $output["Y"] = $fresult["Y"];
        $output["refund"] = $fresult["sell"];
        $output["thumb"] = $this->ItemImage($fresult["id"], $fresult["type"], $tipche, $itemlevel, $harmlvl);
        $output["color"] = $c;
        $output["sn"] = $serial;
        $output["sn2"] = $serial2;
        $output["inf"] = $inf;
        $output["lala"] = $bulo;
        $output["ancsetopt"] = $ancsetopt;
        $output["isanc"] = $ac;
        $output["soc1"] = $soc1;
        $output["soc2"] = $soc2;
        $output["soc3"] = $soc3;
        $output["soc4"] = $soc4;
        $output["soc5"] = $soc5;
        $output["skill2"] = $skill2;
        $output["luck2"] = $luck2;
        $output["opt2"] = $opt2;
        $output["exl2"] = $exl2;
        $output["exc1"] = $iopx1;
        $output["exc2"] = $iopx2;
        $output["exc3"] = $iopx3;
        $output["exc4"] = $iopx4;
        $output["exc5"] = $iopx5;
        $output["exc6"] = $iopx6;
        $output["exc_sx_1"] = $is_excopt_sx_1;
        $output["exc_sx_2"] = $is_excopt_sx_2;
        $output["exc_sx_3"] = $is_excopt_sx_3;
        $output["exc_sx_4"] = $is_excopt_sx_4;
        $output["exc1_name"] = $op1;
        $output["exc2_name"] = $op2;
        $output["exc3_name"] = $op3;
        $output["exc4_name"] = $op4;
        $output["exc5_name"] = $op5;
        $output["exc6_name"] = $op6;
        $output["is_exc_1"] = $is_exc_1;
        $output["is_exc_2"] = $is_exc_2;
        if ($itemListData["KindA"] == "15" || $itemListData["KindA"] == "18") {
            $output["is_exc_3"] = $is_excopt_sx_1;
            $output["is_exc_4"] = $is_excopt_sx_2;
        } else {
            $output["is_exc_3"] = $is_exc_3;
            $output["is_exc_4"] = $is_exc_4;
        }
        if ($itemListData["KindA"] == "14") {
            $output["is_exc_5"] = $is_excopt_sx_1;
            $output["is_exc_6"] = $is_excopt_sx_2;
        } else {
            if ($itemListData["KindA"] == "15" || $itemListData["KindA"] == "18") {
                $output["is_exc_5"] = $is_excopt_sx_3;
                $output["is_exc_6"] = $is_excopt_sx_4;
            } else {
                $output["is_exc_5"] = $is_exc_5;
                $output["is_exc_6"] = $is_exc_6;
            }
        }
        $output["isjog"] = $isjog;
        $output["harmony"] = $harm_code;
        $output["jog_byte"] = $jog;
        $output["harmony_byte"] = $harm;
        $output["harmonylvl_byte"] = $harmlvl;
        $output["Slot"] = $itemListData["Slot"];
        $output["KindA"] = $itemListData["KindA"];
        $output["KindB"] = $itemListData["KindB"];
        $output["itemDetails"] = $itemDetails;
        $output["classReq"] = $classReq;
        return $output;
    }
    public function harmony($cat, $ham, $lvl)
    {
        global $dB;
        switch ($cat) {
            case "0":
                break;
            case "1":
                break;
            case "2":
                break;
            case "3":
                break;
            case "4":
                $harmonyData = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_WEBSHOP_HARMONY WHERE hoption = ? AND hvalue = ? AND itemtype = '1'", [$ham, $lvl]);
                break;
            case "5":
                $harmonyData = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_WEBSHOP_HARMONY WHERE hoption = ? AND hvalue = ? AND itemtype = '2'", [$ham, $lvl]);
                break;
            case "6":
                break;
            case "7":
                break;
            case "8":
                break;
            case "9":
                break;
            case "10":
                break;
            case "11":
                $harmonyData = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_WEBSHOP_HARMONY WHERE hoption = ? AND hvalue = ? AND itemtype = '3'", [$ham, $lvl]);
                break;
            default:
                if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
                    return $harmonyData["hname"];
                }
                return "<br><b>" . $harmonyData["hname"] . "</b><br />";
        }
    }
    public function socket($option)
    {
        global $dB;
        $socketData = $dB->query_fetch_single("SELECT TOP 1 socket_name FROM IMPERIAMUCMS_WEBSHOP_SOCKETS WHERE socket_id = ?", [$option]);
        return $socketData;
    }
    public function ItemImage($theid, $type, $ExclAnci, $lvl = 0, $harmlvl = 0)
    {
        if ("200" <= $theid && $theid <= "261" && $type == "12") {
            $lvl = $harmlvl;
        }
        if (file_exists("" . __PATH_TEMPLATE_ASSETS_ROOT__ . "items/" . $type . "-" . $theid . "-" . $lvl . ".gif")) {
            $output = "" . __PATH_TEMPLATE_ASSETS__ . "items/" . $type . "-" . $theid . "-" . $lvl . ".gif";
        } else {
            if (file_exists("" . __PATH_TEMPLATE_ASSETS_ROOT__ . "items/" . $type . "-" . $theid . ".gif")) {
                $output = "" . __PATH_TEMPLATE_ASSETS__ . "items/" . $type . "-" . $theid . ".gif";
            } else {
                $output = "" . __PATH_TEMPLATE_ASSETS__ . "images/empty.png";
            }
        }
        return $output;
    }
    public function getSocketOption($option, $flag)
    {
        global $dB;
        if ($flag) {
            $socketData = $dB->query_fetch_single("SELECT TOP 1 socket_name, socket_name_lang, socket_lvl, socket_value FROM IMPERIAMUCMS_DATA_SOCKETS WHERE socket_id = ? AND socket_type = '1' AND socket_elem != '0'", [$option]);
        } else {
            $socketData = $dB->query_fetch_single("SELECT TOP 1 socket_name, socket_name_lang, socket_lvl, socket_value FROM IMPERIAMUCMS_DATA_SOCKETS WHERE socket_id = ? AND socket_type = '1'", [$option]);
        }
        return $socketData;
    }
    public function getSocketBonusOption($option)
    {
        global $dB;
        $socketData = $dB->query_fetch_single("SELECT TOP 1 socket_name, socket_name_lang, socket_lvl, socket_value FROM IMPERIAMUCMS_DATA_SOCKETS WHERE socket_id = ? AND socket_type = '2'", [$option]);
        return $socketData;
    }
    public function generateItemTooltip($itemData, $type, $serial, $details, $opts, $exp, $expTime)
    {
        $itemData["name"] = str_replace("\\'", "'", $itemData["name"]);
        $itemData["name"] = str_replace("'", "\\'", $itemData["name"]);
        if ($itemData["level"]) {
            $easytoyou_decoder_beta_not_finish .= " +" . $itemData["level"];
        }
        $tooltip = "";
        if (!empty($itemData["exl"])) {
            $itemData["exl"] = str_replace("\"", "&quot;", $itemData["exl"]);
            $itemData["exl"] = substr($itemData["exl"], 2);
            $itemData["exl"] = str_replace("'", "\\'", $itemData["exl"]);
        }
        if (!empty($itemData["ancsetopt"])) {
            $itemData["ancsetopt"] = str_replace("\"", "&quot;", $itemData["ancsetopt"]);
        }
        if (!empty($itemData["socket"])) {
            $itemData["socket"] = str_replace("\"", "&quot;", $itemData["socket"]);
            $itemData["socket"] = str_replace("'", "\\'", $itemData["socket"]);
        }
        if (!empty($itemData["jog"])) {
            $itemData["jog"] = substr($itemData["jog"], 0, -4) . "";
            $itemData["jog"] = substr($itemData["jog"], 4);
        }
        if ($type == 2) {
            $tooltip = "<span style=&quot;color:" . $itemData["color"] . ";";
            if (!empty($itemData["anco"])) {
                $tooltip .= " background-color: " . $itemData["anco"] . ";";
            }
            $tooltip .= " padding: 2px 2px 2px 2px; cursor: pointer;&quot;";
            $tooltip .= " onmouseover=&quot;Tip(";
        }
        $tooltip .= "'<div class=&quot;item-box&quot;>";
        $tooltip .= "<div style=&quot;";
        if (!empty($itemData["anco"])) {
            $tooltip .= " background-color: " . $itemData["anco"] . ";";
        }
        $tooltip .= "&quot;>";
        $tooltip .= "<div class=&quot;item-name&quot; style=&quot;color:" . $itemData["color"] . ";&quot;>" . $itemData["name"] . "</div>";
        $tooltip .= "</div>";
        $tooltip .= "<img src=&quot;" . $itemData["thumb"] . "&quot;>";
        if ($serial) {
            $tooltip .= "<div class=&quot;item-serial&quot;>" . lang("market_txt_100", true) . " " . $itemData["sn2"] . $itemData["sn"] . "</div>";
        }
        if ($details) {
            $tooltip .= "<div class=&quot;item-info&quot;>" . $itemData["itemDetails"] . "</div>";
        }
        if ($opts && !empty($itemData["jog"])) {
            $tooltip .= "<div class=&quot;item-opt-jog&quot;>" . $itemData["jog"] . "</div>";
        }
        if ($opts && !empty($itemData["harm"])) {
            $tooltip .= "<div class=&quot;item-opt-harmony&quot;>" . $itemData["harm"] . "</div>";
        }
        if ($opts && (!empty($itemData["skill"]) || !empty($itemData["luck"]) || !empty($itemData["opt"]))) {
            $tooltip .= "<div class=&quot;item-info-section&quot;></div>";
        }
        if ($opts && !empty($itemData["skill"])) {
            $tooltip .= "<div class=&quot;item-opt-skill&quot;>" . $itemData["skill"] . "</div>";
        }
        if ($opts && !empty($itemData["luck"])) {
            $tooltip .= "<div class=&quot;item-opt-luck&quot;>" . $itemData["luck"] . "</div>";
        }
        if ($opts && !empty($itemData["opt"])) {
            $tooltip .= "<div class=&quot;item-opt-life&quot;>" . $itemData["opt"] . "</div>";
        }
        if ($opts && !empty($itemData["exl"])) {
            $tooltip .= "<div class=&quot;item-opt-exc&quot;>" . str_replace("^^", "<br>", $itemData["exl"]) . "</div>";
        }
        if ($opts && !empty($itemData["ancsetopt"])) {
            $tooltip .= "<div class=&quot;item-opt-anc&quot;>" . str_replace("^^", "<br>", $itemData["ancsetopt"]) . "</div>";
        }
        if ($opts && !empty($itemData["socket"])) {
            $tooltip .= "<div class=&quot;item-opt-socket&quot;>" . str_replace("^^", "<br>", $itemData["socket"]) . "</div>";
        }
        if ($details && !empty($itemData["classReq"])) {
            $tooltip .= "<div class=&quot;item-class-req&quot;>" . $itemData["classReq"] . "</div>";
        }
        if ($exp && 0 < $expTime) {
            $expMinutes = $expTime;
            $expDays = floor($expMinutes / 1440);
            $expMinutes = $expMinutes - $expDays * 1440;
            $expHours = floor($expMinutes / 60);
            $expMinutes = $expMinutes - $expHours * 60;
            $expText = "";
            $expLength = 0;
            if (0 < $expDays) {
                $expText = lang("claimreward_txt_22", true);
                $expLength = $expDays;
            } else {
                if (0 < $expHours) {
                    $expText = lang("claimreward_txt_21", true);
                    $expLength = $expHours;
                } else {
                    if (0 < $expMinutes) {
                        $expText = lang("claimreward_txt_20", true);
                        $expLength = $expMinutes;
                    }
                }
            }
            $tooltip .= "<div class=&quot;item-expiration&quot;>" . sprintf(lang("claimreward_txt_15", true), $expLength, $expText) . "</div>";
        }
        $tooltip .= "</div>";
        $tooltip .= "', TITLEFONTCOLOR, '" . $itemData["color"] . "', TITLE, '', TITLEBGCOLOR, '" . $itemData["anco"] . "'";
        if ($type == 2) {
            $tooltip .= ");&quot;";
            $tooltip .= " onmouseout=&quot;UnTip();&quot;";
            $tooltip .= ">" . $itemData["name"] . "</span>";
        }
        return $tooltip;
    }
    public function generateStyledItemInfo($itemData, $serial, $details, $opts)
    {
        $itemData["name"] = str_replace("\\'", "'", $itemData["name"]);
        $itemData["name"] = str_replace("'", "\\'", $itemData["name"]);
        if ($itemData["level"]) {
            $easytoyou_decoder_beta_not_finish .= " +" . $itemData["level"];
        }
        $tooltip = "";
        if (!empty($itemData["opt"])) {
            $itemData["opt"] = str_replace("&quot;", "\"", $itemData["opt"]);
        }
        if (!empty($itemData["exl"])) {
            $itemData["exl"] = substr($itemData["exl"], 2);
            $itemData["exl"] = str_replace("'", "\\'", $itemData["exl"]);
        }
        if (!empty($itemData["socket"])) {
            $itemData["socket"] = str_replace("&quot;", "\"", $itemData["socket"]);
            $itemData["socket"] = str_replace("'", "\\'", $itemData["socket"]);
        }
        if (!empty($itemData["jog"])) {
            $itemData["jog"] = substr($itemData["jog"], 0, -4) . "";
            $itemData["jog"] = substr($itemData["jog"], 4);
        }
        $tooltip .= "<div class=\"item-box\">";
        $tooltip .= "<div style=\"";
        if (!empty($itemData["anco"])) {
            $tooltip .= " background-color: " . $itemData["anco"] . ";";
        }
        $tooltip .= "\">";
        $tooltip .= "<div class=\"item-name\" style=\"color:" . $itemData["color"] . ";\">" . $itemData["name"] . "</div>";
        $tooltip .= "</div>";
        $tooltip .= "<img src=\"" . $itemData["thumb"] . "\">";
        if ($serial) {
            $tooltip .= "<div class=\"item-serial\">" . lang("market_txt_100", true) . " " . $itemData["sn2"] . $itemData["sn"] . "</div>";
        }
        if ($details) {
            $tooltip .= "<div class=\"item-info\">" . $itemData["itemDetails"] . "</div>";
        }
        if ($opts && !empty($itemData["jog"])) {
            $tooltip .= "<div class=\"item-opt-jog\">" . $itemData["jog"] . "</div>";
        }
        if ($opts && !empty($itemData["harm"])) {
            $tooltip .= "<div class=\"item-opt-harmony\">" . $itemData["harm"] . "</div>";
        }
        if ($opts && (!empty($itemData["skill"]) || !empty($itemData["luck"]) || !empty($itemData["opt"]))) {
            $tooltip .= "<div class=\"item-info-section\"></div>";
        }
        if ($opts && !empty($itemData["skill"])) {
            $tooltip .= "<div class=\"item-opt-skill\">" . $itemData["skill"] . "</div>";
        }
        if ($opts && !empty($itemData["luck"])) {
            $tooltip .= "<div class=\"item-opt-luck\">" . $itemData["luck"] . "</div>";
        }
        if ($opts && !empty($itemData["opt"])) {
            $tooltip .= "<div class=\"item-opt-life\">" . $itemData["opt"] . "</div>";
        }
        if ($opts && !empty($itemData["exl"])) {
            $tooltip .= "<div class=\"item-opt-exc\">" . str_replace("^^", "<br>", $itemData["exl"]) . "</div>";
        }
        if ($opts && !empty($itemData["ancsetopt"])) {
            $tooltip .= "<div class=\"item-opt-anc\">" . str_replace("^^", "<br>", $itemData["ancsetopt"]) . "</div>";
        }
        if ($opts && !empty($itemData["socket"])) {
            $tooltip .= "<div class=\"item-opt-socket\">" . str_replace("^^", "<br>", $itemData["socket"]) . "</div>";
        }
        if ($details && !empty($itemData["classReq"])) {
            $tooltip .= "<div class=\"item-class-req\">" . $itemData["classReq"] . "</div>";
        }
        $tooltip .= "</div>";
        return $tooltip;
    }
    public function generateItemDetails($itemListData)
    {
        global $custom;
        $itemDetails = "";
        $classReq = "";
        $dropLevel = $itemListData["DropLevel"];
        $isExc = 0;
        $ilvl = 0;
        $ac = 0;
        if (0 < $itemListData["DamageMin"] && 0 < $itemListData["DamageMax"]) {
            if ($isExc) {
                $minMaxDmgExc = floor($itemListData["DamageMin"] * 25 / $dropLevel + 5);
            }
            $mindmg = $ilvl * 3 + $itemListData["DamageMin"];
            $maxdmg = $ilvl * 3 + $itemListData["DamageMax"];
            if (10 <= $ilvl) {
                $mindmg += 1;
                $maxdmg += 1;
            }
            if (11 <= $ilvl) {
                $mindmg += 2;
                $maxdmg += 2;
            }
            if (12 <= $ilvl) {
                $mindmg += 3;
                $maxdmg += 3;
            }
            if (13 <= $ilvl) {
                $mindmg += 4;
                $maxdmg += 4;
            }
            if (14 <= $ilvl) {
                $mindmg += 5;
                $maxdmg += 5;
            }
            if (15 <= $ilvl) {
                $mindmg += 6;
                $maxdmg += 6;
            }
            if ($isExc) {
                $mindmg += $minMaxDmgExc;
                $maxdmg += $minMaxDmgExc;
            }
            if ($itemListData["TwoHand"] == "0") {
                $itemDetails .= "<br>" . sprintf(lang("item_detail_webshop_txt_4", true), $mindmg, $maxdmg);
            } else {
                $itemDetails .= "<br>" . sprintf(lang("item_detail_webshop_txt_5", true), $mindmg, $maxdmg);
            }
        }
        if (0 < $itemListData["Defense"]) {
            if ($isExc) {
                $defenseExc = floor($itemListData["Defense"] * 12 / $dropLevel + $dropLevel / 5 + 4);
            }
            $defense = $ilvl * 3 + $itemListData["Defense"];
            if (10 <= $ilvl) {
                $defense += 1;
            }
            if (11 <= $ilvl) {
                $defense += 2;
            }
            if (12 <= $ilvl) {
                $defense += 3;
            }
            if (13 <= $ilvl) {
                $defense += 4;
            }
            if (14 <= $ilvl) {
                $defense += 5;
            }
            if (15 <= $ilvl) {
                $defense += 6;
            }
            if ($isExc) {
                $defense += $defenseExc;
            }
            $itemDetails .= "<br>" . sprintf(lang("item_detail_webshop_txt_1", true), $defense);
        }
        if (0 < $itemListData["AttackSpeed"]) {
            $itemDetails .= "<br>" . sprintf(lang("item_detail_webshop_txt_2", true), $itemListData["AttackSpeed"]);
        }
        if (0 < $itemListData["Durability"]) {
            if ($itemListData["id"] == 14 && $itemListData["index"] == 21 && $ilvl == 3) {
                $itemLevelTmp = 0;
            } else {
                $itemLevelTmp = $ilvl;
            }
            $maxDur = 0;
            if ($itemListData["id"] == 14 && $itemListData["index"] == 29 || $itemListData["id"] == 14 && $itemListData["index"] == 100 || $itemListData["id"] == 14 && $itemListData["index"] == 101 || $itemListData["id"] == 14 && $itemListData["index"] == 110 || $itemListData["id"] == 14 && $itemListData["index"] == 153 || $itemListData["id"] == 14 && $itemListData["index"] == 154 || $itemListData["id"] == 14 && $itemListData["index"] == 155 || $itemListData["id"] == 14 && $itemListData["index"] == 156) {
                $maxDur = 1;
            } else {
                if ($itemLevelTmp < 5) {
                    $maxDur = $itemListData["Durability"] + $itemLevelTmp;
                } else {
                    if (5 <= $itemLevelTmp) {
                        if ($itemLevelTmp == 10) {
                            $maxDur = $itemListData["Durability"] + $itemLevelTmp * 2 - 3;
                        } else {
                            if ($itemLevelTmp == 11) {
                                $maxDur = $itemListData["Durability"] + $itemLevelTmp * 2 - 1;
                            } else {
                                if ($itemLevelTmp == 12) {
                                    $maxDur = $itemListData["Durability"] + $itemLevelTmp * 2 + 2;
                                } else {
                                    if ($itemLevelTmp == 13) {
                                        $maxDur = $itemListData["Durability"] + $itemLevelTmp * 2 + 6;
                                    } else {
                                        if ($itemLevelTmp == 14) {
                                            $maxDur = $itemListData["Durability"] + $itemLevelTmp * 2 + 11;
                                        } else {
                                            if ($itemLevelTmp == 15) {
                                                $maxDur = $itemListData["Durability"] + $itemLevelTmp * 2 + 17;
                                            } else {
                                                $maxDur = $itemListData["Durability"] + $itemLevelTmp * 2 - 4;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if (0 < $ac) {
                    $maxDur += 20;
                }
                if ($isExc == 1) {
                    $maxDur += 15;
                }
            }
            if (255 < $maxDur) {
                $maxDur = 255;
            }
            $itemdur = $maxDur;
            if ($itemListData["Slot"] != "-1") {
                if (200 <= $itemListData["index"] && $itemListData["index"] <= 261 && $itemListData["id"] == 12) {
                    $itemDetails .= "<br>" . sprintf(lang("item_detail_txt_15", true), "[" . $itemdur . "/" . $maxDur . "]");
                } else {
                    $itemDetails .= "<br>" . sprintf(lang("item_detail_webshop_txt_14", true), $maxDur);
                }
            }
        }
        if (0 < $itemListData["MagicDurability"] && $itemListData["Durability"] == 0) {
            $itemDetails .= "<br>" . sprintf(lang("item_detail_webshop_txt_14", true), $itemListData["MagicDurability"]);
        }
        if (0 < $itemListData["ReqLevel"]) {
            $levelRatio = 0;
            if ($itemListData["KindA"] == "6") {
                if ($itemListData["KindB"] == "23" || $itemListData["KindB"] == "26" || $itemListData["KindB"] == "27" || $itemListData["KindB"] == "28") {
                    $levelRatio = 4;
                } else {
                    if ($itemListData["KindB"] == "24") {
                        $levelRatio = 5;
                    }
                }
            } else {
                if ($itemListData["KindA"] == "8" && $itemListData["KindB"] == "43") {
                    $levelRatio = 4;
                }
            }
            $reqLevel = $itemListData["ReqLevel"] + $levelRatio * $ilvl;
            $itemDetails .= "<br>" . sprintf(lang("item_detail_webshop_txt_3", true), $reqLevel);
        }
        if (0 < $itemListData["ReqStrength"]) {
            $reqStr = $itemListData["ReqStrength"] * ($itemListData["DropLevel"] + $ilvl * 3) * 3 / 100 + 20;
            $itemDetails .= "<br>" . sprintf(lang("item_detail_webshop_txt_7", true), $reqStr);
        }
        if (0 < $itemListData["ReqDexterity"]) {
            $reqAgi = $itemListData["ReqDexterity"] * ($itemListData["DropLevel"] + $ilvl * 3) * 3 / 100 + 20;
            $itemDetails .= "<br>" . sprintf(lang("item_detail_webshop_txt_8", true), $reqAgi);
        }
        if (0 < $itemListData["ReqVitality"]) {
            $reqVit = $itemListData["ReqVitality"] * ($itemListData["DropLevel"] + $ilvl * 3) * 3 / 100 + 20;
            $itemDetails .= "<br>" . sprintf(lang("item_detail_webshop_txt_9", true), $reqVit);
        }
        if (0 < $itemListData["ReqEnergy"]) {
            $reqEne = $itemListData["ReqEnergy"] * ($itemListData["DropLevel"] + $ilvl * 3) * 3 / 100 + 20;
            $itemDetails .= "<br>" . sprintf(lang("item_detail_webshop_txt_10", true), $reqEne);
        }
        if (0 < $itemListData["ReqCommand"]) {
            $reqCmd = $itemListData["ReqCommand"] * ($itemListData["DropLevel"] + $ilvl * 3) * 3 / 100 + 20;
            $itemDetails .= "<br>" . sprintf(lang("item_detail_webshop_txt_11", true), $reqCmd);
        }
        if (131 <= config("server_files_season", true)) {
            $gmCode = 3;
            $bmCode = 19;
            $heCode = 35;
            $dsCode = 83;
        } else {
            $gmCode = 2;
            $bmCode = 18;
            $heCode = 34;
            $dsCode = 82;
        }
        if ($itemListData["DarkWizard"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][0][0]);
        } else {
            if ($itemListData["DarkWizard"] == "2") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][1][0]);
            } else {
                if ($itemListData["DarkWizard"] == "3") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][$gmCode][0]);
                } else {
                    if ($itemListData["DarkWizard"] == "4") {
                        $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][7][0]);
                    }
                }
            }
        }
        if ($itemListData["DarkKnight"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][16][0]);
        } else {
            if ($itemListData["DarkKnight"] == "2") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][17][0]);
            } else {
                if ($itemListData["DarkKnight"] == "3") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][$bmCode][0]);
                } else {
                    if ($itemListData["DarkKnight"] == "4") {
                        $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][23][0]);
                    }
                }
            }
        }
        if ($itemListData["FairyElf"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][32][0]);
        } else {
            if ($itemListData["FairyElf"] == "2") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][33][0]);
            } else {
                if ($itemListData["FairyElf"] == "3") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][$heCode][0]);
                } else {
                    if ($itemListData["FairyElf"] == "4") {
                        $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][39][0]);
                    }
                }
            }
        }
        if ($itemListData["MagicGladiator"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][48][0]);
        } else {
            if ($itemListData["MagicGladiator"] == "3") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][50][0]);
            } else {
                if ($itemListData["MagicGladiator"] == "4") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][54][0]);
                }
            }
        }
        if ($itemListData["DarkLord"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][64][0]);
        } else {
            if ($itemListData["DarkLord"] == "3") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][66][0]);
            } else {
                if ($itemListData["DarkLord"] == "4") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][70][0]);
                }
            }
        }
        if ($itemListData["Summoner"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][80][0]);
        } else {
            if ($itemListData["Summoner"] == "2") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][81][0]);
            } else {
                if ($itemListData["Summoner"] == "3") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][$dsCode][0]);
                } else {
                    if ($itemListData["Summoner"] == "4") {
                        $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][87][0]);
                    }
                }
            }
        }
        if ($itemListData["RageFighter"] == "1") {
            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][96][0]);
        } else {
            if ($itemListData["RageFighter"] == "3") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][98][0]);
            } else {
                if ($itemListData["RageFighter"] == "4") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][102][0]);
                }
            }
        }
        if (100 <= config("server_files_season", true)) {
            if ($itemListData["GrowLancer"] == "1") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][112][0]);
            } else {
                if ($itemListData["GrowLancer"] == "3") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][114][0]);
                } else {
                    if ($itemListData["GrowLancer"] == "4") {
                        $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][118][0]);
                    }
                }
            }
        }
        if (140 <= config("server_files_season", true)) {
            if ($itemListData["RuneWizard"] == "1") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][128][0]);
            } else {
                if ($itemListData["RuneWizard"] == "2") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][129][0]);
                } else {
                    if ($itemListData["RuneWizard"] == "3") {
                        $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][131][0]);
                    } else {
                        if ($itemListData["RuneWizard"] == "4") {
                            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][135][0]);
                        }
                    }
                }
            }
        }
        if (150 <= config("server_files_season", true)) {
            if ($itemListData["Slayer"] == "1") {
                $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][144][0]);
            } else {
                if ($itemListData["Slayer"] == "2") {
                    $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][145][0]);
                } else {
                    if ($itemListData["Slayer"] == "3") {
                        $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][147][0]);
                    } else {
                        if ($itemListData["Slayer"] == "4") {
                            $classReq .= "<br>" . sprintf(lang("item_detail_txt_6", true), $custom["character_class"][151][0]);
                        }
                    }
                }
            }
        }
        if (config("server_files_season", true) < 100 && "1" <= $itemListData["DarkWizard"] && "1" <= $itemListData["DarkKnight"] && "1" <= $itemListData["FairyElf"] && "1" <= $itemListData["MagicGladiator"] && "1" <= $itemListData["DarkLord"] && "1" <= $itemListData["Summoner"] && "1" <= $itemListData["RageFighter"]) {
            $classReq = "";
        }
        if (config("server_files_season", true) < 140 && "1" <= $itemListData["DarkWizard"] && "1" <= $itemListData["DarkKnight"] && "1" <= $itemListData["FairyElf"] && "1" <= $itemListData["MagicGladiator"] && "1" <= $itemListData["DarkLord"] && "1" <= $itemListData["Summoner"] && "1" <= $itemListData["RageFighter"] && "1" <= $itemListData["GrowLancer"]) {
            $classReq = "";
        }
        if (config("server_files_season", true) < 150 && "1" <= $itemListData["DarkWizard"] && "1" <= $itemListData["DarkKnight"] && "1" <= $itemListData["FairyElf"] && "1" <= $itemListData["MagicGladiator"] && "1" <= $itemListData["DarkLord"] && "1" <= $itemListData["Summoner"] && "1" <= $itemListData["RageFighter"] && "1" <= $itemListData["GrowLancer"]) {
            $classReq = "";
        }
        if (150 <= config("server_files_season", true) && "1" <= $itemListData["DarkWizard"] && "1" <= $itemListData["DarkKnight"] && "1" <= $itemListData["FairyElf"] && "1" <= $itemListData["MagicGladiator"] && "1" <= $itemListData["DarkLord"] && "1" <= $itemListData["Summoner"] && "1" <= $itemListData["RageFighter"] && "1" <= $itemListData["GrowLancer"] && "1" <= $itemListData["RuneWizard"] && "1" <= $itemListData["Slayer"]) {
            $classReq = "";
        }
        $return = [];
        $return["Slot"] = $itemListData["Slot"];
        $return["KindA"] = $itemListData["KindA"];
        $return["KindB"] = $itemListData["KindB"];
        $return["Option"] = $itemListData["Option"];
        $return["itemDetails"] = $itemDetails;
        $return["classReq"] = $classReq;
        return $return;
    }
    public function getItemFromDb($cat, $index, $level)
    {
        global $dB;
        return $dB->query_fetch_single("\r\n            SELECT TOP 1 *\r\n            FROM IMPERIAMUCMS_ITEMS\r\n            WHERE type = ? AND id = ? AND level = ?\r\n        ", [$cat, $index, $level]);
    }
    public function generateItemHex($itemCat, $itemId, $level, $life, $luck, $skill, $durability, $excOpts, $ancient, $refinary, $harmonyId, $harmonyLvl, $soc1, $soc2, $soc3, $soc4, $soc5, $soc1_seed, $soc2_seed, $soc3_seed, $soc4_seed, $soc5_seed, $overrideLvl, $overrideExc, $useSockets, $useBonusSocket, $socketBonus, $kindA, $kindB, $elementType, $serial = NULL, $serial2 = NULL)
    {
        global $dB;
        $itemData = $this->loadItemFromItemList($itemCat, $itemId);
        $excData = $this->loadExcOptForItem($itemCat, $itemId, $kindA, $kindB);
        if ($serial === NULL && $serial2 === NULL) {
            $serial = $dB->query_fetch_single("exec WZ_GetItemSerial2 1");
            $serial = $serial["ItemSerial"];
            while (strlen($serial) < 16) {
                $serial = "0" . $serial;
            }
            $serial2 = substr($serial, 0, 8);
            $serial = substr($serial, 8, 8);
        }
        $hop = 0;
        $xl = 0;
        if (0 < $overrideLvl) {
            $level = $overrideLvl;
        }
        $xlCounter = 0;
        foreach ($excData as $thisOpt) {
            if ($thisOpt["Number"] < 6 && $excOpts[$xlCounter]) {
                if ($thisOpt["Number"] == 0) {
                    $xl += 32;
                }
                if ($thisOpt["Number"] == 1) {
                    $xl += 16;
                }
                if ($thisOpt["Number"] == 2) {
                    $xl += 8;
                }
                if ($thisOpt["Number"] == 3) {
                    $xl += 4;
                }
                if ($thisOpt["Number"] == 4) {
                    $xl += 2;
                }
                if ($thisOpt["Number"] == 5) {
                    $xl += 1;
                }
            }
            $xlCounter++;
        }
        if ($kindA == "19") {
            $xl = 0;
        }
        if (0 < $overrideExc) {
            $xl = $overrideExc;
        }
        if ($luck) {
            $hop += 4;
        }
        if ($skill) {
            $hop += 128;
        }
        if (4 <= $life) {
            $hop += $life - 4;
            $xl += 64;
        } else {
            $hop += $life;
        }
        if (0 < $level) {
            $hop += $level * 8;
        }
        if (256 <= $itemId) {
            $itemId = $itemId - 256;
            $xl += 128;
        }
        if ($useSockets == "1") {
            if (254 <= $soc1 && $soc1_seed != "-1") {
                $soc1 -= 254;
                $ancient += 64;
            }
            if (254 <= $soc2 && $soc2_seed != "-1") {
                $soc2 -= 254;
                $ancient += 16;
            }
            if (254 <= $soc3 && $soc3_seed != "-1") {
                $soc3 -= 254;
                $ancient += 4;
            }
            if (254 <= $soc4 && $soc4_seed != "-1") {
                $soc4 -= 254;
                $ancient += 1;
            }
            if (254 <= $soc5 && $soc5_seed != "-1") {
                $soc5 -= 254;
                $xl += 16;
            }
        }
        if ($kindA == "6" && $kindB == "76") {
            $wings4thSocket = "";
            $wings4thHarmony = "";
            foreach ($excOpts["exc"] as $thisExc) {
                if ($thisExc != NULL) {
                    $gradeDataTmp = explode(":", $thisExc);
                    $wings4thSocket .= dechex($gradeDataTmp[0]);
                    $wings4thSocket .= dechex($gradeDataTmp[1]);
                } else {
                    $wings4thSocket .= "FF";
                }
            }
            $wings4thSocket = strtoupper($wings4thSocket);
            while (strlen($wings4thSocket) < 8) {
                $wings4thSocket .= "F";
            }
            if ($excOpts["elem"][1] != NULL) {
                $addElemDataTmp = explode(":", $excOpts["elem"][1]);
                $wings4thSocket .= dechex($addElemDataTmp[0]);
                $wings4thSocket .= dechex($addElemDataTmp[1]);
            } else {
                $wings4thSocket .= "FF";
            }
            if ($excOpts["elem"][0] != NULL) {
                $mainElemDataTmp = explode(":", $excOpts["elem"][0]);
                $wings4thHarmony .= dechex($mainElemDataTmp[0]);
                $wings4thHarmony .= dechex($mainElemDataTmp[1]);
            } else {
                $wings4thHarmony .= "FF";
            }
        }
        $itemhex = sprintf("%02X", $itemId, 0);
        $itemhex .= sprintf("%02X", $hop, 0);
        $itemhex .= sprintf("%02X", $durability, 0);
        $itemhex .= sprintf("%08X", $serial2, 0);
        $itemhex .= sprintf("%02X", $xl, 0);
        $itemhex .= sprintf("%02X", $ancient, 0);
        $itemhex .= dechex($itemCat);
        if ($refinary) {
            $itemhex .= "8";
        } else {
            $itemhex .= "0";
        }
        if ($useSockets == "1" && $useBonusSocket) {
            if ($socketBonus === NULL) {
                $socketBonus = 255;
            }
            $itemhex .= sprintf("%02X", $socketBonus, 0);
        } else {
            if ($kindA == "6" && $kindB == "76") {
                $itemhex .= $wings4thHarmony;
            } else {
                $itemhex .= dechex($harmonyId);
                if ($kindA == "8" && $kindB == "43") {
                    $itemhex .= dechex($elementType);
                } else {
                    $itemhex .= dechex($harmonyLvl);
                }
            }
        }
        if ($useSockets == "1") {
            if ($soc1 === NULL) {
                $soc1 = 255;
            }
            if ($soc2 === NULL) {
                $soc2 = 255;
            }
            if ($soc3 === NULL) {
                $soc3 = 255;
            }
            if ($soc4 === NULL) {
                $soc4 = 255;
            }
            if ($soc5 === NULL) {
                $soc5 = 255;
            }
            $itemhex .= sprintf("%02X", $soc1, 0);
            $itemhex .= sprintf("%02X", $soc2, 0);
            $itemhex .= sprintf("%02X", $soc3, 0);
            $itemhex .= sprintf("%02X", $soc4, 0);
            $itemhex .= sprintf("%02X", $soc5, 0);
        } else {
            if ($kindA == "8" && $kindB == "43") {
                if ($soc1 === NULL) {
                    $soc1 = 255;
                }
                if ($soc2 === NULL) {
                    $soc2 = 255;
                }
                if ($soc3 === NULL) {
                    $soc3 = 255;
                }
                if ($soc4 === NULL) {
                    $soc4 = 255;
                }
                if ($soc5 === NULL) {
                    $soc5 = 255;
                }
                $itemhex .= sprintf("%02X", $soc1, 0);
                $itemhex .= sprintf("%02X", $soc2, 0);
                $itemhex .= sprintf("%02X", $soc3, 0);
                $itemhex .= sprintf("%02X", $soc4, 0);
                $itemhex .= sprintf("%02X", $soc5, 0);
            } else {
                if ($kindA == "14" || $kindA == "15" || $kindA == "18" || $kindA == "100") {
                    $sxCounter = 0;
                    $sxSocketHex = "";
                    foreach ($excData as $thisOpt) {
                        if (6 <= $thisOpt["Number"] && $excOpts[$sxCounter]) {
                            $sxSocketHex .= sprintf("%02X", $thisOpt["Number"], 0);
                        }
                        $sxCounter++;
                    }
                    while (strlen($sxSocketHex) < 10) {
                        $sxSocketHex .= "F";
                    }
                    $itemhex .= $sxSocketHex;
                } else {
                    if ($kindA == "6" && $kindB == "76") {
                        $itemhex .= $wings4thSocket;
                    } else {
                        if ($kindA == "19" && $kindB == "77") {
                            $earringSocketHex = "";
                            if ($itemData["Slot"] == "238") {
                                if ($itemData["index"] == "450") {
                                    if ($excOpts[0]) {
                                        $earringSocketHex .= "99";
                                    }
                                    if ($excOpts[1]) {
                                        $earringSocketHex .= "E4";
                                    }
                                    if ($excOpts[2]) {
                                        $earringSocketHex .= "EE";
                                    }
                                    if ($excOpts[3]) {
                                        $earringSocketHex .= "F6";
                                    }
                                    if ($excOpts[4]) {
                                        $earringSocketHex .= "58";
                                    }
                                } else {
                                    if ($excOpts[0]) {
                                        $earringSocketHex .= "99";
                                    }
                                    if ($excOpts[1]) {
                                        $earringSocketHex .= "BC";
                                    }
                                    if ($excOpts[2]) {
                                        $earringSocketHex .= "96";
                                    }
                                    if ($excOpts[3]) {
                                        $earringSocketHex .= "86";
                                    }
                                    if ($excOpts[4]) {
                                        $earringSocketHex .= "58";
                                    }
                                }
                            } else {
                                if ($itemData["Slot"] == "237") {
                                    if ($itemData["index"] == "458") {
                                        if ($excOpts[0]) {
                                            $earringSocketHex .= "4D";
                                        }
                                        if ($excOpts[1]) {
                                            $earringSocketHex .= "8A";
                                        }
                                        if ($excOpts[2]) {
                                            $earringSocketHex .= "7A";
                                        }
                                        if ($excOpts[3]) {
                                            $earringSocketHex .= "73";
                                        }
                                        if ($excOpts[4]) {
                                            $earringSocketHex .= "60";
                                        }
                                    } else {
                                        if ($excOpts[0]) {
                                            $earringSocketHex .= "4D";
                                        }
                                        if ($excOpts[1]) {
                                            $earringSocketHex .= "8A";
                                        }
                                        if ($excOpts[2]) {
                                            $earringSocketHex .= "7A";
                                        }
                                        if ($excOpts[3]) {
                                            $earringSocketHex .= "73";
                                        }
                                        if ($excOpts[4]) {
                                            $earringSocketHex .= "60";
                                        }
                                    }
                                }
                            }
                            while (strlen($earringSocketHex) < 10) {
                                $earringSocketHex .= "F";
                            }
                            $itemhex .= $earringSocketHex;
                        } else {
                            $itemhex .= "FFFFFFFFFF";
                        }
                    }
                }
            }
        }
        $itemhex .= sprintf("%08X", $serial, 0);
        $itemhex .= "FFFFFFFFFFFFFFFFFFFFFFFF";
        $itemhex = strtoupper($itemhex);
        return $itemhex;
    }
    public function admincpItemEditorVault($data, $isExpanded, $token)
    {
        $vault = "";
        if ($isExpanded) {
            $vault .= "\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12 col-md-6 text-right\">\r\n                <table class=\"my-vault text-center\">\r\n                    <tr>";
        } else {
            $vault .= "\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12 text-center\">\r\n                <table class=\"my-vault text-center\">\r\n                    <tr>";
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
            $item = $this->ItemInfo(substr($user_items, $il * $i, $il));
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
                    $wh_content .= "\r\n                        <td class=\"wh-item\" colspan=\"" . $InsPosX . "\" rowspan=\"" . $InsPosY . "\" style=\"width:" . 32 * $InsPosX . "px;height:" . 32 * $InsPosY . "px;margin:0;padding:0;\">\r\n                            <a href=\"" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=" . $i . "&type=1") . "\" onmouseover=\"Tip(" . $this->generateItemTooltip($item, 1, 1, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\"><img src=\"" . $item["thumb"] . "\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\" class=\"m\"></a>\r\n                        </td>";
                } else {
                    $wh_content .= "<td class='wh-item-empty' colspan='1' rowspan='1' style='width:32px;height:32px;margin:0;padding:0;'></td>";
                }
            }
        }
        $vault .= $wh_content;
        $vault .= "\r\n                    </tr>\r\n                </table>\r\n            </div>";
        if ($isExpanded) {
            $vault .= "\r\n            <div class=\"col-xs-12 col-md-6 text-left\">\r\n                <table class=\"my-vault-ext text-center\">\r\n                    <tr>";
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
                $item = $this->ItemInfo(substr($user_items, $il * $i, $il));
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
                        $wh_content .= "\r\n                        <td class=\"wh-item\" colspan=\"" . $InsPosX . "\" rowspan=\"" . $InsPosY . "\" style=\"width:" . 32 * $InsPosX . "px;height:" . 32 * $InsPosY . "px;margin:0;padding:0;\">\r\n                            <a href=\"" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=" . ($i + 120) . "&type=1") . "\" onmouseover=\"Tip(" . $this->generateItemTooltip($item, 1, 1, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\"><img src=\"" . $item["thumb"] . "\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\" class=\"m\"></a>\r\n                        </td>";
                    } else {
                        $wh_content .= "<td class='wh-item-empty' colspan='1' rowspan='1' style='width:32px;height:32px;margin:0;padding:0;'></td>";
                    }
                }
            }
            $vault .= $wh_content;
            $vault .= "        \r\n                    </tr>\r\n                </table>\r\n            </div>";
        }
        $vault .= "\r\n        </div>";
        return $vault;
    }
    public function admincpItemEditorInventory($name)
    {
        global $dB;
        $name = xss_clean($name);
        $inventory = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE Name = ?), 2) AS items", [$name]);
        $sqll = $inventory["items"];
        $i = 0;
        while ($i <= 238) {
            if ($i == 12) {
                $i = 236;
            } else {
                $item[$i] = $this->ItemInfo(substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
                if ($item[$i] != __ITEM_EMPTY__) {
                    $item[$i] = $this->ItemInfo(substr($sqll, __ITEM_LENGTH__ * $i, __ITEM_LENGTH__));
                    if ($item[$i] == NULL) {
                        $item[$i]["thumb"] = "";
                        $title_content[$i] = lang("profiles_txt_48", true);
                    } else {
                        $title_content[$i] = $this->generateItemTooltip($item[$i], 1, 1, 1, 1, 0, 0);
                    }
                }
                $i++;
            }
        }
        $bgImage = "inventory_bg2";
        if (132 <= config("server_files_season", true)) {
            $bgImage = "inventory_bg";
        }
        $inv = "<div class='col-xs-12'><div style='width: 421px; height: 345px; background:url(" . __PATH_TEMPLATE_ASSETS__ . "images/" . $bgImage . ".png) no-repeat center top;'>";
        if ($item[0]["thumb"]) {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=0&type=2") . "'><div class='profile_item0' style='background: url(" . $item[0]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[0] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        } else {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=0&type=2") . "'><div class='profile_item0' style='background: url(" . $item[0]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        }
        if ($item[1]["thumb"]) {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=1&type=2") . "'><div class='profile_item1' style='background: url(" . $item[1]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[1] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        } else {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=1&type=2") . "'><div class='profile_item1' style='background: url(" . $item[1]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        }
        if ($item[2]["thumb"]) {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=2&type=2") . "'><div class='profile_item2' style='background: url(" . $item[2]["thumb"] . ") no-repeat center center;' \tonmouseover=\"Tip(" . $title_content[2] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        } else {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=2&type=2") . "'><div class='profile_item2' style='background: url(" . $item[2]["thumb"] . ") no-repeat center center;' \tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        }
        if ($item[3]["thumb"]) {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=3&type=2") . "'><div class='profile_item3' style='background: url(" . $item[3]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[3] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        } else {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=3&type=2") . "'><div class='profile_item3' style='background: url(" . $item[3]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        }
        if ($item[4]["thumb"]) {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=4&type=2") . "'><div class='profile_item4' style='background: url(" . $item[4]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[4] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        } else {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=4&type=2") . "'><div class='profile_item4' style='background: url(" . $item[4]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        }
        if ($item[5]["thumb"]) {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=5&type=2") . "'><div class='profile_item5' style='background: url(" . $item[5]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[5] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        } else {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=5&type=2") . "'><div class='profile_item5' style='background: url(" . $item[5]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        }
        if ($item[6]["thumb"]) {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=6&type=2") . "'><div class='profile_item6' style='background: url(" . $item[6]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[6] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        } else {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=6&type=2") . "'><div class='profile_item6' style='background: url(" . $item[6]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        }
        if ($item[7]["thumb"]) {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=7&type=2") . "'><div class='profile_item7' style='background: url(" . $item[7]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[7] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        } else {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=7&type=2") . "'><div class='profile_item7' style='background: url(" . $item[7]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        }
        if ($item[8]["thumb"]) {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=8&type=2") . "'><div class='profile_item8' style='background: url(" . $item[8]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[8] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        } else {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=8&type=2") . "'><div class='profile_item8' style='background: url(" . $item[8]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        }
        if ($item[9]["thumb"]) {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=9&type=2") . "'><div class='profile_item9' style='background: url(" . $item[9]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[9] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        } else {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=9&type=2") . "'><div class='profile_item9' style='background: url(" . $item[9]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        }
        if ($item[10]["thumb"]) {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=10&type=2") . "'><div class='profile_item10' style='background: url(" . $item[10]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[10] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        } else {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=10&type=2") . "'><div class='profile_item10' style='background: url(" . $item[10]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        }
        if ($item[11]["thumb"]) {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=11&type=2") . "'><div class='profile_item11' style='background: url(" . $item[11]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[11] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        } else {
            $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=11&type=2") . "'><div class='profile_item11' style='background: url(" . $item[11]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
        }
        if (70 <= config("server_files_season", true)) {
            if ($item[236]["thumb"]) {
                $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=236&type=2") . "'><div class='profile_item236' style='background: url(" . $item[236]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[236] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
            } else {
                $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=236&type=2") . "'><div class='profile_item236' style='background: url(" . $item[236]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
            }
            if (140 <= config("server_files_season", true)) {
                if ($item[237]["thumb"]) {
                    $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=237&type=2") . "'><div class='profile_item237' style='background: url(" . $item[237]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[237] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
                } else {
                    $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=237&type=2") . "'><div class='profile_item237' style='background: url(" . $item[237]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
                }
                if ($item[238]["thumb"]) {
                    $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=238&type=2") . "'><div class='profile_item238' style='background: url(" . $item[238]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip(" . $title_content[238] . ");\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
                } else {
                    $inv .= "<a href='" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=238&type=2") . "'><div class='profile_item238' style='background: url(" . $item[238]["thumb"] . ") no-repeat center center;'\tonmouseover=\"Tip('" . lang("profiles_txt_48", true) . "');\" onmouseout=\"UnTip();\">&nbsp;</div></a>";
                }
            }
        }
        $inv .= "</div></div>";
        $mainInv = "";
        $mainInv .= "\r\n        <div class=\"col-xs-12 col-lg-6 text-center\">\r\n            <table class=\"my-vault text-center\">\r\n                <tr>";
        $il = __ITEM_LENGTH__;
        $wh_content = "";
        $user_items = $inventory["items"];
        $check = "011111111";
        $xx = 0;
        $yy = 1;
        $line = 1;
        $i = 12;
        while ($i < 76) {
            $tmpI = $i - 12;
            if ($xx == 8) {
                $xx = 1;
                $yy++;
            } else {
                $xx++;
            }
            $TT = substr($check, $xx, 1);
            if (round($tmpI / 8) == $tmpI / 8 && $tmpI != 0) {
                $wh_content .= "</tr><tr>";
                $line++;
            }
            $item = $this->ItemInfo(substr($user_items, $il * $i, $il));
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
                if ($item["name"]) {
                    $wh_content .= "\r\n                    <td class=\"wh-item\" colspan=\"" . $InsPosX . "\" rowspan=\"" . $InsPosY . "\" style=\"width:" . 32 * $InsPosX . "px;height:" . 32 * $InsPosY . "px;margin:0;padding:0;\">\r\n                        <a href=\"" . admincp_base("items_editor&account=" . $_GET["account"] . "&char=" . $_GET["char"] . "&slot=" . $i . "&type=2") . "\" onmouseover=\"Tip(" . $this->generateItemTooltip($item, 1, 1, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\"><img src=\"" . $item["thumb"] . "\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\" class=\"m\"></a>\r\n                    </td>";
                } else {
                    $wh_content .= "<td class='wh-item-empty' colspan='1' rowspan='1' style='width:32px;height:32px;margin:0;padding:0;'></td>";
                }
            }
            $i++;
        }
        $mainInv .= $wh_content;
        $mainInv .= "\r\n                </tr>\r\n            </table>\r\n        </div>";
        $inv1 = "";
        $inv1 .= "\r\n        <div class=\"col-xs-12 col-lg-6 text-center\">\r\n            <table class=\"my-vault text-center\">\r\n                <tr>";
        $il = __ITEM_LENGTH__;
        $wh_content = "";
        $user_items = $inventory["items"];
        $check = "011111111";
        $xx = 0;
        $yy = 1;
        $line = 1;
        $i = 76;
        while ($i < 108) {
            $tmpI = $i - 76;
            if ($xx == 8) {
                $xx = 1;
                $yy++;
            } else {
                $xx++;
            }
            $TT = substr($check, $xx, 1);
            if (round($tmpI / 8) == $tmpI / 8 && $tmpI != 0) {
                $wh_content .= "</tr><tr>";
                $line++;
            }
            $item = $this->ItemInfo(substr($user_items, $il * $i, $il));
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
                if ($item["name"]) {
                    $wh_content .= "\r\n                    <td class=\"wh-item\" colspan=\"" . $InsPosX . "\" rowspan=\"" . $InsPosY . "\" style=\"width:" . 32 * $InsPosX . "px;height:" . 32 * $InsPosY . "px;margin:0;padding:0;\">\r\n                        <a href=\"\" onmouseover=\"Tip(" . $this->generateItemTooltip($item, 1, 1, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\"><img src=\"" . $item["thumb"] . "\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\" class=\"m\"></a>\r\n                    </td>";
                } else {
                    $wh_content .= "<td class='wh-item-empty' colspan='1' rowspan='1' style='width:32px;height:32px;margin:0;padding:0;'></td>";
                }
            }
            $i++;
        }
        $inv1 .= $wh_content;
        $inv1 .= "\r\n                </tr>\r\n            </table>\r\n        </div>";
        $inv2 = "";
        $inv2 .= "\r\n        <div class=\"col-xs-12 col-lg-6 text-center\">\r\n            <table class=\"my-vault text-center\">\r\n                <tr>";
        $il = __ITEM_LENGTH__;
        $wh_content = "";
        $user_items = $inventory["items"];
        $check = "011111111";
        $xx = 0;
        $yy = 1;
        $line = 1;
        $i = 108;
        while ($i < 140) {
            $tmpI = $i - 76;
            if ($xx == 8) {
                $xx = 1;
                $yy++;
            } else {
                $xx++;
            }
            $TT = substr($check, $xx, 1);
            if (round($tmpI / 8) == $tmpI / 8 && $tmpI != 0) {
                $wh_content .= "</tr><tr>";
                $line++;
            }
            $item = $this->ItemInfo(substr($user_items, $il * $i, $il));
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
                if ($item["name"]) {
                    $wh_content .= "\r\n                    <td class=\"wh-item\" colspan=\"" . $InsPosX . "\" rowspan=\"" . $InsPosY . "\" style=\"width:" . 32 * $InsPosX . "px;height:" . 32 * $InsPosY . "px;margin:0;padding:0;\">\r\n                        <a href=\"\" onmouseover=\"Tip(" . $this->generateItemTooltip($item, 1, 1, 1, 1, 0, 0) . ")\" onmouseout=\"UnTip()\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\"><img src=\"" . $item["thumb"] . "\" style=\"width:" . 24 * $InsPosX . "px;height:" . 24 * $InsPosY . "px;\" class=\"m\"></a>\r\n                    </td>";
                } else {
                    $wh_content .= "<td class='wh-item-empty' colspan='1' rowspan='1' style='width:32px;height:32px;margin:0;padding:0;'></td>";
                }
            }
            $i++;
        }
        $inv2 .= $wh_content;
        $inv2 .= "\r\n                </tr>\r\n            </table>\r\n        </div>";
        return $inv . $mainInv . $inv1 . $inv2;
    }
    public function loadItemFromVault($accountName, $slot)
    {
        global $dB;
        $result = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Items FROM warehouse WHERE AccountID = ?), 2) AS inv", [$accountName]);
        $inv = $result["inv"];
        $item = $this->ItemInfo(substr($inv, __ITEM_LENGTH__ * $slot, __ITEM_LENGTH__));
        return $item;
    }
    public function loadItemFromInventory($accountName, $charName, $slot)
    {
        global $dB;
        $result = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT Inventory FROM Character WHERE AccountID = ? AND Name = ?), 2) AS inv", [$accountName, $charName]);
        $inv = $result["inv"];
        $item = $this->ItemInfo(substr($inv, __ITEM_LENGTH__ * $slot, __ITEM_LENGTH__));
        return $item;
    }
    public function getPentagramFreeSlots($username)
    {
        global $dB;
        $pentagramUserData = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT PentagramInfo FROM IGC_PentagramInfo WHERE AccountID = ? AND (Name = ? OR Name = ?) AND JewelPos = ?), 2) AS pentagram", [$username, NULL, "", 1]);
        $pentagramData = $pentagramUserData["pentagram"];
        $freeSlots = [];
        if ($pentagramData != NULL) {
            $x = 0;
            while ($x <= 253) {
                array_push($freeSlots, $x);
                $x++;
            }
            $i = 0;
            while ($i < 8500) {
                $pentagram = substr($pentagramData, 34 * $i, 34);
                if ($pentagram != "FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF") {
                    $jewelIndex = hexdec(substr($pentagram, 2, 2));
                    unset($freeSlots[$jewelIndex]);
                }
                $i = $i + 34;
            }
            $freeSlots = array_values($freeSlots);
        } else {
            $freeSlots = [0, 1, 2, 3, 4];
        }
        return $freeSlots;
    }
    public function generatePentagramHex($jewelPos, $jewelIndex, $itemType, $itemIndex, $elementType, $errtelLevel, $slot1, $slot1lvl, $slot2, $slot2lvl, $slot3, $slot3lvl, $slot4, $slot4lvl, $slot5, $slot5lvl)
    {
        $hex = "";
        $hex = sprintf("%02X", $jewelPos, 0);
        $hex .= sprintf("%02X", $jewelIndex, 0);
        $hex .= sprintf("%02X", $itemType, 0);
        $hex .= sprintf("%04X", $itemIndex, 0);
        $hex .= sprintf("%02X", $elementType, 0);
        $hex .= sprintf("%02X", $errtelLevel, 0);
        $hex .= sprintf("%02X", $slot1, 0);
        $hex .= sprintf("%02X", $slot1lvl, 0);
        $hex .= sprintf("%02X", $slot2, 0);
        $hex .= sprintf("%02X", $slot2lvl, 0);
        $hex .= sprintf("%02X", $slot3, 0);
        $hex .= sprintf("%02X", $slot3lvl, 0);
        $hex .= sprintf("%02X", $slot4, 0);
        $hex .= sprintf("%02X", $slot4lvl, 0);
        $hex .= sprintf("%02X", $slot5, 0);
        $hex .= sprintf("%02X", $slot5lvl, 0);
        return $hex;
    }
    public function insertPentagramData($userid, $username, $charName = NULL, $jewelPos, $pentagramHex)
    {
        global $dB;
        if ($charName == NULL) {
            $pentagramUserData = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT PentagramInfo FROM IGC_PentagramInfo WHERE AccountID = ? AND JewelPos = ?), 2) AS pentagram", [$username, $jewelPos]);
        } else {
            $pentagramUserData = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT PentagramInfo FROM IGC_PentagramInfo WHERE AccountID = ? AND Name = ? AND JewelPos = ?), 2) AS pentagram", [$username, $charName, $jewelPos]);
        }
        $pentagramData = $pentagramUserData["pentagram"];
        if ($pentagramData == NULL) {
            $pentagramData = $pentagramHex;
            $i = 34;
            while ($i < 8500) {
                $pentagramData .= "FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF";
                $i = $i + 34;
            }
            $pentagramData = "0x" . $pentagramData;
            $result = $dB->query("INSERT INTO IGC_PentagramInfo (UserGuid, AccountID, Name, JewelPos, PentagramInfo) VALUES(?, ?, ?, ?, " . $pentagramData . ")", [$userid, $username, $charName, $jewelPos]);
        } else {
            $i = 0;
            while ($i < 250) {
                $pentagram = substr($pentagramData, 34 * $i, 34);
                if ($pentagram == "FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF") {
                    $pentagramData = substr_replace($pentagramData, $pentagramHex, 34 * $i, 34);
                } else {
                    $i++;
                }
            }
            $pentagramData = "0x" . $pentagramData;
            if ($charName == NULL) {
                $result = $dB->query("UPDATE IGC_PentagramInfo SET PentagramInfo = " . $pentagramData . " WHERE AccountID = ? AND JewelPos = ?", [$username, $jewelPos]);
            } else {
                $result = $dB->query("UPDATE IGC_PentagramInfo SET PentagramInfo = " . $pentagramData . " WHERE AccountID = ? AND Name = ? AND JewelPos = ?", [$username, $charName, $jewelPos]);
            }
        }
        if ($result) {
            return true;
        }
        return false;
    }
    public function getPentagramData($username, $charName = NULL, $jewelPos = 0, $jewelIndex)
    {
        global $dB;
        if ($charName == NULL) {
            $pentagramData = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT PentagramInfo FROM IGC_PentagramInfo WHERE AccountID = ? AND JewelPos = ?), 2) AS pentagram", [$username, $jewelPos]);
        } else {
            $pentagramData = $dB->query_fetch_single("SELECT CONVERT(VARCHAR(MAX), (SELECT PentagramInfo FROM IGC_PentagramInfo WHERE AccountID = ? AND Name = ? AND JewelPos = ?), 2) AS pentagram", [$username, $charName, $jewelPos]);
        }
        $pentagramData = $pentagramData["pentagram"];
        $return = [];
        $i = 0;
        while ($i < 250) {
            $pentagram = substr($pentagramData, 34 * $i, 34);
            $currJewelIndex = hexdec(substr($pentagram, 2, 2));
            if ($currJewelIndex == $jewelIndex) {
                $return["AccountID"] = $username;
                $return["Name"] = $charName;
                $return["JewelPos"] = hexdec(substr($pentagram, 0, 2));
                $return["JewelIndex"] = $currJewelIndex;
                $return["ItemType"] = hexdec(substr($pentagram, 4, 2));
                $return["ItemIndex"] = hexdec(substr($pentagram, 6, 4));
                $return["MainAttribute"] = hexdec(substr($pentagram, 10, 2));
                $return["JewelLevel"] = hexdec(substr($pentagram, 12, 2));
                $return["Rank1"] = hexdec(substr($pentagram, 14, 2));
                $return["Rank1Level"] = hexdec(substr($pentagram, 16, 2));
                $return["Rank2"] = hexdec(substr($pentagram, 18, 2));
                $return["Rank2Level"] = hexdec(substr($pentagram, 20, 2));
                $return["Rank3"] = hexdec(substr($pentagram, 22, 2));
                $return["Rank3Level"] = hexdec(substr($pentagram, 24, 2));
                $return["Rank4"] = hexdec(substr($pentagram, 26, 2));
                $return["Rank4Level"] = hexdec(substr($pentagram, 28, 2));
                $return["Rank5"] = hexdec(substr($pentagram, 30, 2));
                $return["Rank5Level"] = hexdec(substr($pentagram, 32, 2));
            } else {
                $i++;
            }
        }
        return $return;
    }
    public function generateItemName($name, $level)
    {
        if (0 < $level) {
            return $name . " +" . $level;
        }
        return $name;
    }
}

?>