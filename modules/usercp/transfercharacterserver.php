<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $General = new xGeneral();
        if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("transfercharacterserver")) {
            $breadcrumb = generateBreadcrumb();
            echo "\r\n    <h3>\r\n        " . lang("transfercharacterserver_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
            if (mconfig("active")) {
                if (!$common->accountOnline($_SESSION["username"])) {
                    $dB3 = new dB($config["SQL2_DB_HOST"], $config["SQL2_DB_PORT"], $config["SQL2_DB_NAME"], $config["SQL2_DB_USER"], $config["SQL2_DB_PASS"], $config["SQL_PDO_DRIVER"]);
                    if ($dB3->dead) {
                        if (config("error_reporting", true)) {
                            throw new Exception($dB3->error);
                        }
                        throw new Exception("Connection to database server failed. [03]");
                    }
                    $step = xss_clean(Decode($_POST[Encode("step")]));
                    $showSelectChar = false;
                    $showSelectName = false;
                    $showPrice = false;
                    $showTransfer = false;
                    if ($step == NULL || $step == "") {
                        $showSelectChar = true;
                    } else {
                        if ($step == "select-name") {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                $charName = xss_clean(Decode($_POST["character"]));
                                $charNewName = $charName;
                                $checkGuild = $dB3->query_fetch_single("SELECT TOP 1 Name, G_Name FROM GuildMember WHERE Name = ?", [$charName]);
                                if ($checkGuild["G_Name"] != NULL) {
                                    $showSelectChar = true;
                                    message("error", lang("transfercharacterserver_txt_4", true));
                                } else {
                                    $showSelectName = true;
                                }
                                $checkName = $dB->query_fetch_single("SELECT Name FROM Character WHERE Name = ?", [$charName]);
                                if ($checkName["Name"] != NULL) {
                                    $charNewName = NULL;
                                }
                            } else {
                                message("notice", lang("global_module_13", true));
                                $showSelectChar = true;
                            }
                        } else {
                            if ($step == "show-price") {
                                if ($_SESSION["token"] == $_POST["token"]) {
                                    $charName = xss_clean($_POST["newname"]);
                                    $charOldName = xss_clean(Decode($_POST[Encode("charname")]));
                                    $charNewName = $charName;
                                    if (10 < strlen($charName)) {
                                        redirect();
                                    }
                                    if (strlen($charName) < 4 || !preg_match("/^[0-9a-zA-Z]+\$/", $charName)) {
                                        $showSelectName = true;
                                        message("error", lang("transfercharacterserver_txt_11", true));
                                    } else {
                                        $checkName = $dB->query_fetch_single("SELECT Name FROM Character WHERE Name = ?", [$charName]);
                                        if ($checkName["Name"] != NULL) {
                                            $showSelectName = true;
                                            $charNewName = NULL;
                                        } else {
                                            $showPrice = true;
                                        }
                                    }
                                } else {
                                    message("notice", lang("global_module_13", true));
                                    $showSelectChar = true;
                                }
                            } else {
                                if ($step == "transfer") {
                                    if ($_SESSION["token"] == $_POST["token"]) {
                                        $charName = xss_clean(Decode($_POST[Encode("charname")]));
                                        $charOldName = xss_clean(Decode($_POST[Encode("charoldname")]));
                                        if (10 < strlen($charName)) {
                                            redirect();
                                        }
                                        if (strlen($charName) < 4 || !preg_match("/^[0-9a-zA-Z]+\$/", $charName)) {
                                            $showSelectName = true;
                                            message("error", lang("transfercharacterserver_txt_11", true));
                                        } else {
                                            $charNewName = $charName;
                                            $checkName = $dB->query_fetch_single("SELECT Name FROM Character WHERE Name = ?", [$charName]);
                                            if ($checkName["Name"] != NULL) {
                                                $showSelectName = true;
                                                $charNewName = NULL;
                                            } else {
                                                $newTakenSlots = $dB->query_fetch_single("SELECT COUNT(Name) as totalChars FROM Character WHERE AccountID = ?", [$_SESSION["username"]]);
                                                if (10 <= $newTakenSlots["totalChars"]) {
                                                    message("error", lang("transfercharacterserver_txt_7", true));
                                                } else {
                                                    $transferLog = $dB->query_fetch_single("SELECT COUNT(*) as totalTransfers FROM IMPERIAMUCMS_TRANSFER_CHAR_SERVER_LOGS WHERE AccountID = ?", [$_SESSION["username"]]);
                                                    $checkPrice = false;
                                                    if (mconfig("free_transfers") <= $transferLog["totalTransfers"]) {
                                                        $wcoins = $dB3->query_fetch_single("SELECT WCoin FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                                                        if (mconfig("price_wcoin") <= $wcoins["WCoin"]) {
                                                            $checkPrice = true;
                                                        }
                                                    } else {
                                                        $checkPrice = true;
                                                    }
                                                    if ($checkPrice) {
                                                        if ($common->beginDbTrans($_SESSION["username"])) {
                                                            $oldCharacter = $dB3->query_fetch_single("\r\n                    SELECT [AccountID],[Name],[cLevel],[LevelUpPoint],[Class],[Experience],[Strength],[Dexterity],[Vitality],[Energy],\r\n                    [Money],[Life],[MaxLife],[Mana],[MaxMana],[MapNumber],[MapPosX],[MapPosY],[MapDir],[PkCount],[PkLevel],[PkTime],[MDate],[LDate],[CtlCode],\r\n                    CONVERT(VARCHAR(MAX), Quest, 2) AS Quest,[Leadership],[ChatLimitTime],[FruitPoint],[RESETS],CONVERT(VARCHAR(MAX), Inventory, 2) AS Inventory,\r\n                    [mLevel],[mlPoint],[mlExperience],[mlNextExp],[InventoryExpansion],[Ruud],[MuHelperData],[i4thSkillPoint]\r\n                    FROM Character WHERE AccountID = ? AND Name = ?", [$_SESSION["username"], $charOldName]);
                                                            if (mconfig("max_clvl") < $oldCharacter["cLevel"]) {
                                                                $oldCharacter["cLevel"] = mconfig("max_clvl");
                                                            }
                                                            if (mconfig("max_mlvl") < $oldCharacter["mLevel"]) {
                                                                $oldCharacter["mLevel"] = mconfig("max_mlvl");
                                                            }
                                                            $oldCharacter["mlPoint"] = $oldCharacter["mLevel"];
                                                            if (400 < $oldCharacter["mlPoint"]) {
                                                                $oldCharacter["mlPoint"] = 400;
                                                            }
                                                            $oldCharacter["i4thSkillPoint"] = $oldCharacter["mLevel"] - 400;
                                                            if ($oldCharacter["i4thSkillPoint"] < 0) {
                                                                $oldCharacter["i4thSkillPoint"] = 0;
                                                            }
                                                            $charClass = NULL;
                                                            if (144 <= $oldCharacter["Class"]) {
                                                                $charClass = 144;
                                                            } else {
                                                                if (128 <= $oldCharacter["Class"]) {
                                                                    $charClass = 128;
                                                                } else {
                                                                    if (112 <= $oldCharacter["Class"]) {
                                                                        $charClass = 112;
                                                                    } else {
                                                                        if (96 <= $oldCharacter["Class"]) {
                                                                            $charClass = 96;
                                                                        } else {
                                                                            if (80 <= $oldCharacter["Class"]) {
                                                                                $charClass = 80;
                                                                            } else {
                                                                                if (64 <= $oldCharacter["Class"]) {
                                                                                    $charClass = 64;
                                                                                } else {
                                                                                    if (48 <= $oldCharacter["Class"]) {
                                                                                        $charClass = 48;
                                                                                    } else {
                                                                                        if (32 <= $oldCharacter["Class"]) {
                                                                                            $charClass = 32;
                                                                                        } else {
                                                                                            if (16 <= $oldCharacter["Class"]) {
                                                                                                $charClass = 16;
                                                                                            } else {
                                                                                                $charClass = 0;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            $createChar = $dB->query_fetch_single("exec WZ_CreateCharacter ?, ?, ?", [$_SESSION["username"], $charName, $charClass]);
                                                            $createCharResult = intval(bin2hex($createChar["Result"]));
                                                            if ($createCharResult == "3") {
                                                                message("error", lang("transfercharacterserver_txt_7", true));
                                                            } else {
                                                                if ($createCharResult == "0") {
                                                                    message("error", sprintf(lang("transfercharacterserver_txt_6", true), $charName));
                                                                } else {
                                                                    if ($createCharResult == "1") {
                                                                        $updateChar = $dB->query("\r\n                    UPDATE Character SET \r\n                        cLevel = ?, mLevel = ?, LevelUpPoint = ?, Class = ?, Experience = ?,\r\n                        Strength = ?, Dexterity = ?, Vitality = ?, Energy = ?, Leadership = ?,\r\n                        Money = ?, Life = ?, MaxLife = ?, Mana = ?, MaxMana = ?, \r\n                        MapNumber = ?, MapPosX = ?, MapPosY = ?, MapDir = ?, PkCount = ?,\r\n                        PkLevel = ?, PkTime = ?, MDate = ?, LDate = ?, CtlCode = ?,\r\n                        ChatLimitTime = ?, FruitPoint = ?, RESETS = ?, i4thSkillPoint = ?,\r\n                        mlPoint = ?, mlExperience = ?, mlNextExp = ?, Ruud = ?\r\n                    WHERE AccountID = ? AND Name = ?", [$oldCharacter["cLevel"], $oldCharacter["mLevel"], $oldCharacter["LevelUpPoint"], $oldCharacter["Class"], $oldCharacter["Experience"], $oldCharacter["Strength"], $oldCharacter["Dexterity"], $oldCharacter["Vitality"], $oldCharacter["Energy"], $oldCharacter["Leadership"], $oldCharacter["Money"], $oldCharacter["Life"], $oldCharacter["MaxLife"], $oldCharacter["Mana"], $oldCharacter["MaxMana"], $oldCharacter["MapNumber"], $oldCharacter["MapPosX"], $oldCharacter["MapPosY"], $oldCharacter["MapDir"], $oldCharacter["PkCount"], $oldCharacter["PkLevel"], $oldCharacter["PkTime"], $oldCharacter["MDate"], $oldCharacter["LDate"], $oldCharacter["CtlCode"], $oldCharacter["ChatLimitTime"], $oldCharacter["FruitPoint"], $oldCharacter["RESETS"], $oldCharacter["i4thSkillPoint"], $oldCharacter["mlPoint"], $oldCharacter["mlExperience"], $oldCharacter["mlNextExp"], $oldCharacter["Ruud"], $_SESSION["username"], $charName]);
                                                                        $updateChar2 = $dB->query("UPDATE Character SET Quest = 0x" . $oldCharacter["Quest"] . " WHERE AccountID = '" . $_SESSION["username"] . "' AND Name = '" . $charName . "'");
                                                                        $updateChar3 = $dB->query("UPDATE Character SET MuHelperData = 0x" . $oldCharacter["MuHelperData"] . " WHERE AccountID = '" . $_SESSION["username"] . "' AND Name = '" . $charName . "'");
                                                                        if (mconfig("transfer_inv")) {
                                                                            $updateChar4 = $dB->query("UPDATE Character SET Inventory = 0x" . $oldCharacter["Inventory"] . " WHERE AccountID = '" . $_SESSION["username"] . "' AND Name = '" . $charName . "'");
                                                                        }
                                                                        if (mconfig("transfer_inv_ext")) {
                                                                            $updateChar5 = $dB->query("UPDATE Character SET InventoryExpansion = " . $oldCharacter["InventoryExpansion"] . " WHERE AccountID = '" . $_SESSION["username"] . "' AND Name = '" . $charName . "'");
                                                                        }
                                                                        $dB3->query("UPDATE Character SET CtlCode = ? WHERE Name = ?", [1, $charOldName]);
                                                                        if (mconfig("free_transfers") <= $transferLog["totalTransfers"]) {
                                                                            $updateCoins = $dB3->query("UPDATE T_InGameShop_Point SET WCoin = WCoin - ? WHERE AccountID = ?", [mconfig("price_wcoin"), $_SESSION["username"]]);
                                                                        }
                                                                        $addLog = $dB->query("INSERT INTO IMPERIAMUCMS_TRANSFER_CHAR_SERVER_LOGS (Date, AccountID, OldName, NewName, Data) VALUES (?, ?, ?, ?, ?)", [date("Y-m-d H:i:s", time()), $_SESSION["username"], $charOldName, $charName, NULL]);
                                                                        $common->endDbTrans($_SESSION["username"]);
                                                                        message("success", lang("transfercharacterserver_txt_14", true));
                                                                    } else {
                                                                        message("error", lang("error_23", true));
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        message("error", lang("transfercharacterserver_txt_13", true));
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        message("notice", lang("global_module_13", true));
                                        $showSelectChar = true;
                                    }
                                }
                            }
                        }
                    }
                    $token = time();
                    $_SESSION["token"] = $token;
                    if ($showSelectChar) {
                        $newTakenSlots = $dB->query_fetch_single("SELECT COUNT(Name) as totalChars FROM Character WHERE AccountID = ?", [$_SESSION["username"]]);
                        if (10 <= $newTakenSlots["totalChars"]) {
                            message("error", lang("transfercharacterserver_txt_7", true));
                        } else {
                            $oldCharacters = $dB3->query_fetch("SELECT [AccountID],[Name],[Class] FROM Character WHERE AccountID = ?", [$_SESSION["username"]]);
                            if (is_array($oldCharacters)) {
                                $characters = "";
                                $charDivs = "";
                                $token = time();
                                $_SESSION["token"] = $token;
                                foreach ($oldCharacters as $thisCharacter) {
                                    $characters .= "<option value=\"" . Encode($thisCharacter[_CLMN_CHR_NAME_]) . "\">" . $common->replaceHtmlSymbols($thisCharacter[_CLMN_CHR_NAME_]) . " (" . $custom["character_class"][$thisCharacter["Class"]][0] . ")</option>";
                                }
                                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-center\">\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("transfercharacterserver_txt_2", true) . "</label>\r\n                    <select name=\"character\" class=\"form-control\" tabindex=\"1\">\r\n                        " . $characters . "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"hidden\" name=\"" . Encode("step") . "\" value=\"" . Encode("select-name") . "\" />\r\n                    <input type=\"submit\" name=\"submit\" value=\"" . lang("transfercharacterserver_txt_3", true) . "\" class=\"btn btn-warning full-width-btn\" tabindex=\"2\">\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
                            } else {
                                message("error", lang("error_46", true));
                            }
                        }
                    } else {
                        if ($showSelectName) {
                            message("info", lang("transfercharacterserver_txt_11", true));
                            if ($charNewName != $charName) {
                                message("error", sprintf(lang("transfercharacterserver_txt_6", true), $charName));
                            }
                            echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-center\">\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("transfercharacterserver_txt_5", true) . "</label>\r\n                    <input type=\"text\" name=\"newname\" value=\"" . $charNewName . "\" class=\"form-control\" tabindex=\"1\" maxlength=\"10\" required=\"required\" />\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"hidden\" name=\"" . Encode("charname") . "\" value=\"" . Encode($charName) . "\" />\r\n                    <input type=\"hidden\" name=\"" . Encode("step") . "\" value=\"" . Encode("show-price") . "\" />\r\n                    <input type=\"submit\" name=\"submit\" value=\"" . lang("transfercharacterserver_txt_3", true) . "\" class=\"btn btn-warning full-width-btn\" tabindex=\"2\">\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
                        } else {
                            if ($showPrice) {
                                $transferLog = $dB->query_fetch_single("SELECT COUNT(*) as totalTransfers FROM IMPERIAMUCMS_TRANSFER_CHAR_SERVER_LOGS WHERE AccountID = ?", [$_SESSION["username"]]);
                                if (mconfig("free_transfers") <= $transferLog["totalTransfers"]) {
                                    $priceInfo = sprintf(lang("transfercharacterserver_txt_10", true), mconfig("price_wcoin"));
                                } else {
                                    $priceInfo = lang("transfercharacterserver_txt_9", true);
                                }
                                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-center\">\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    " . $priceInfo . "\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"hidden\" name=\"" . Encode("step") . "\" value=\"" . Encode("transfer") . "\" />\r\n                    <input type=\"hidden\" name=\"" . Encode("charname") . "\" value=\"" . Encode($charName) . "\" />\r\n                    <input type=\"hidden\" name=\"" . Encode("charoldname") . "\" value=\"" . Encode($charOldName) . "\" />\r\n                    <input type=\"submit\" name=\"submit\" value=\"" . lang("transfercharacterserver_txt_8", true) . "\" class=\"btn btn-warning full-width-btn\" tabindex=\"1\">\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
                            }
                        }
                    }
                } else {
                    message("error", lang("error_47", true));
                }
            } else {
                message("error", lang("transfercharacterserver_txt_12", true));
            }
        }
    }
}

?>