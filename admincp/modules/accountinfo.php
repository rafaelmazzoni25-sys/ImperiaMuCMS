<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$accountInfoConfig["showGeneralInfo"] = true;
$accountInfoConfig["showStatusInfo"] = true;
$accountInfoConfig["showIpInfo"] = true;
$accountInfoConfig["showCharacters"] = true;
if (check_value($_GET["id"])) {
    try {
        if (check_value($_POST["editaccount_submit"])) {
            try {
                if (!check_value($_POST["action"])) {
                    throw new Exception("Invalid request.");
                }
                $sendEmail = check_value($_POST["editaccount_sendmail"]) && $_POST["editaccount_sendmail"] == 1 ? true : false;
                $accountInfo = $common->accountInformation($_GET["id"]);
                if (!$accountInfo) {
                    throw new Exception("Could not retrieve account information (invalid account).");
                }
                switch ($_POST["action"]) {
                    case "changepassword":
                        if (!check_value($_POST["changepassword_newpw"])) {
                            throw new Exception("Please enter the new password.");
                        }
                        if (!Validator::PasswordLength($_POST["changepassword_newpw"])) {
                            throw new Exception("Invalid password.");
                        }
                        if (!$common->changePassword($accountInfo[_CLMN_MEMBID_], $accountInfo[_CLMN_USERNM_], $_POST["changepassword_newpw"])) {
                            throw new Exception("Could not change password.");
                        }
                        message("success", "Password updated!");
                        if (check_value($_POST["editaccount_sendmail"])) {
                            $email = new Email();
                            $email->setTemplate("ADMIN_CHANGE_PASSWORD");
                            $email->addVariable("{USERNAME}", $accountInfo[_CLMN_USERNM_]);
                            $email->addVariable("{NEW_PASSWORD}", $_POST["changepassword_newpw"]);
                            $email->addAddress($accountInfo[_CLMN_EMAIL_]);
                            $email->send();
                        }
                        break;
                    case "changeemail":
                        if (!check_value($_POST["changeemail_newemail"])) {
                            throw new Exception("Please enter the new email.");
                        }
                        if (!Validator::Email($_POST["changeemail_newemail"])) {
                            throw new Exception("Invalid email address.");
                        }
                        if ($common->emailExists($_POST["changeemail_newemail"])) {
                            throw new Exception("Another account with the same email already exists.");
                        }
                        if (!$common->updateEmail($accountInfo[_CLMN_MEMBID_], $_POST["changeemail_newemail"])) {
                            throw new Exception("Could not update email.");
                        }
                        message("success", "Email address updated!");
                        if (check_value($_POST["editaccount_sendmail"])) {
                            $email = new Email();
                            $email->setTemplate("ADMIN_CHANGE_EMAIL");
                            $email->addVariable("{USERNAME}", $accountInfo[_CLMN_USERNM_]);
                            $email->addVariable("{NEW_EMAIL}", $_POST["changeemail_newemail"]);
                            $email->addAddress($accountInfo[_CLMN_EMAIL_]);
                            $email->send();
                        }
                        break;
                    default:
                        throw new Exception("Invalid request.");
                }
            } catch (Exception $ex) {
                message("error", $ex->getMessage());
            }
        }
        $accountInfo = $common->accountInformation($_GET["id"]);
        if (!$accountInfo) {
            throw new Exception("Could not retrieve account information (invalid account).");
        }
        if (check_value($_POST["editvip_submit"])) {
            $type = htmlspecialchars($_POST["vip_type"]);
            $date = htmlspecialchars($_POST["vip_date"]);
            if (strtolower($type) == "null") {
                $type = NULL;
            }
            if (strtolower($date) == "null") {
                $date = NULL;
            }
            if (config("SQL_USE_2_DB", true)) {
                $update = $dB2->query("UPDATE T_VIPList SET Type = ?, Date = ? WHERE AccountID = ?", [$type, $date, $accountInfo[_CLMN_USERNM_]]);
            } else {
                $update = $dB->query("UPDATE T_VIPList SET Type = ?, Date = ? WHERE AccountID = ?", [$type, $date, $accountInfo[_CLMN_USERNM_]]);
            }
            if ($update) {
                message("success", "VIP was successfully updated.");
            } else {
                message("error", "Unexpected error occurred, please check your values.");
            }
        }
        if (check_value($_POST["addvip_submit"])) {
            $type = htmlspecialchars($_POST["vip_type"]);
            $date = htmlspecialchars($_POST["vip_date"]);
            if (strtolower($type) == "null") {
                $type = NULL;
            }
            if (strtolower($date) == "null") {
                $date = NULL;
            }
            if (config("SQL_USE_2_DB", true)) {
                $check = $dB2->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$accountInfo[_CLMN_USERNM_]]);
                if ($check["AccountID"] == NULL) {
                    $insert = $dB2->query("INSERT INTO T_VIPList (AccountID, Type, Date) VALUES (?, ?, ?)", [$accountInfo[_CLMN_USERNM_], $type, $date]);
                } else {
                    $insert = $dB2->query("UPDATE T_VIPList SET Type = ?, Date = ? WHERE AccountID = ?", [$type, $date, $accountInfo[_CLMN_USERNM_]]);
                }
            } else {
                $check = $dB->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$accountInfo[_CLMN_USERNM_]]);
                if ($check["AccountID"] == NULL) {
                    $insert = $dB->query("INSERT INTO T_VIPList (AccountID, Type, Date) VALUES (?, ?, ?)", [$accountInfo[_CLMN_USERNM_], $type, $date]);
                } else {
                    $insert = $dB->query("UPDATE T_VIPList SET Type = ?, Date = ? WHERE AccountID = ?", [$type, $date, $accountInfo[_CLMN_USERNM_]]);
                }
            }
            if ($insert) {
                message("success", "VIP was successfully added.");
            } else {
                message("error", "Unexpected error occurred, please check your values.");
            }
        }
        if (check_value($_GET["delete"]) && $_GET["delete"] == "vip") {
            if (config("SQL_USE_2_DB", true)) {
                $update = $dB2->query("UPDATE T_VIPList SET Type = ?, Date = ? WHERE AccountID = ?", [NULL, NULL, $accountInfo[_CLMN_USERNM_]]);
            } else {
                $update = $dB->query("UPDATE T_VIPList SET Type = ?, Date = ? WHERE AccountID = ?", [NULL, NULL, $accountInfo[_CLMN_USERNM_]]);
            }
            if ($update) {
                message("success", "VIP was successfully deleted.");
            } else {
                message("error", "Unexpected error occurred, please check your values.");
            }
            redirect(2, "admincp/index.php?module=accountinfo&id=" . $_GET["id"], 3);
        }
        if (check_value($_GET["delete_item"]) && is_numeric($_GET["delete_item"])) {
            $delete = $dB->query("DELETE FROM IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY WHERE id = ?", [$_GET["delete_item"]]);
            if ($delete) {
                message("success", "Item #" . $_GET["delete_item"] . " was deleted successfully from " . $accountInfo[_CLMN_USERNM_] . "'s items inventory.");
            } else {
                message("error", "Could not delete item #" . $_GET["delete_item"] . " from " . $accountInfo[_CLMN_USERNM_] . "'s items inventory.");
            }
        }
        if (check_value($_POST["save_balance"])) {
            $platinum = $_POST["platinum"];
            $gold = $_POST["gold"];
            $silver = $_POST["silver"];
            $wcoinc = $_POST["wcoinc"];
            $wcoinp = $_POST["wcoinp"];
            $gp = $_POST["gp"];
            if (is_numeric($platinum) && is_numeric($gold) && is_numeric($silver) && is_numeric($wcoinc) && is_numeric($wcoinp) && is_numeric($gp)) {
                if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                    $oldCredits = $dB2->query_fetch_single("SELECT platinum, gold, silver FROM MEMB_CREDITS WHERE memb___id = ?", [$accountInfo[_CLMN_USERNM_]]);
                    $update1 = $dB2->query("UPDATE MEMB_CREDITS SET platinum = ?, gold = ?, silver = ? WHERE memb___id = ?", [$platinum, $gold, $silver, $accountInfo[_CLMN_USERNM_]]);
                } else {
                    $oldCredits = $dB->query_fetch_single("SELECT platinum, gold, silver FROM MEMB_CREDITS WHERE memb___id = ?", [$accountInfo[_CLMN_USERNM_]]);
                    $update1 = $dB->query("UPDATE MEMB_CREDITS SET platinum = ?, gold = ?, silver = ? WHERE memb___id = ?", [$platinum, $gold, $silver, $accountInfo[_CLMN_USERNM_]]);
                }
                if (100 <= config("server_files_season", true)) {
                    $oldPoints = $dB->query_fetch_single("SELECT WCoin, GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$accountInfo[_CLMN_USERNM_]]);
                    $wcoinDB = "WCoin";
                    $update2 = $dB->query("UPDATE T_InGameShop_Point SET WCoin = ?, GoblinPoint = ? WHERE AccountID = ?", [$wcoinc, $gp, $accountInfo[_CLMN_USERNM_]]);
                } else {
                    $oldPoints = $dB->query_fetch_single("SELECT WCoinC, WCoinP, GoblinPoint FROM T_InGameShop_Point WHERE AccountID = ?", [$accountInfo[_CLMN_USERNM_]]);
                    $wcoinDB = "WCoinC";
                    if ($oldPoints["WCoinP"] != NULL) {
                        $update2 = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = ?, WCoinP = ?, GoblinPoint = ? WHERE AccountID = ?", [$wcoinc, $wcoinp, $gp, $accountInfo[_CLMN_USERNM_]]);
                    } else {
                        $update2 = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = ?, GoblinPoint = ? WHERE AccountID = ?", [$wcoinc, $gp, $accountInfo[_CLMN_USERNM_]]);
                    }
                }
                if ($update1 && $update2) {
                    message("success", "Balance for account " . $accountInfo[_CLMN_USERNM_] . " was updated successfully.");
                    $fp = fopen(__ROOT_DIR__ . "__logs/admincp_" . date("Y-m-d", time()) . ".log", "ab");
                    if ($fp) {
                        fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] [Username: " . $_SESSION["username"] . "] Updated balance on account \"" . $accountInfo[_CLMN_USERNM_] . "\" [Platinum: " . $oldCredits["platinum"] . "->" . $platinum . "] [Gold: " . $oldCredits["gold"] . "->" . $gold . "] [Silver: " . $oldCredits["silver"] . "->" . $silver . "] [WCoinC: " . $oldPoints[$wcoinDB] . "->" . $wcoinc . "] [WCoinP: " . $oldPoints["WCoinP"] . "->" . $wcoinp . "] [GoblinPoint: " . $oldPoints["GoblinPoint"] . "->" . $gp . "]" . PHP_EOL);
                        fclose($fp);
                    }
                } else {
                    message("success", "Could not update balance information for account " . $accountInfo[_CLMN_USERNM_] . ".");
                }
            } else {
                message("error", "All values must be numbers.");
            }
        }
        if (check_value($_POST["save_webbank"])) {
            $zen = $_POST["zen"];
            $bless = $_POST["bless"];
            $soul = $_POST["soul"];
            $life = $_POST["life"];
            $chaos = $_POST["chaos"];
            $harmony = $_POST["harmony"];
            $creation = $_POST["creation"];
            $guardian = $_POST["guardian"];
            if (is_numeric($zen) && is_numeric($bless) && is_numeric($soul) && is_numeric($life) && is_numeric($chaos) && is_numeric($harmony) && is_numeric($creation) && is_numeric($guardian)) {
                $customitems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
                $error = false;
                $customFields = "";
                if (is_array($customitems)) {
                    foreach ($customitems as $thisItem) {
                        $dbName = str_replace(" ", "_", $thisItem["name"]);
                        $customFields .= ", " . $dbName . " = " . $_POST[$dbName];
                        if (!is_numeric($_POST[$dbName])) {
                            $error = true;
                            $customFields = "";
                            message("error", "All values must be a number greater than zero.");
                        }
                    }
                }
                if (!$error) {
                    $oldBalance = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$accountInfo[_CLMN_USERNM_]]);
                    $update1 = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK SET zen = ?, bless = ?, soul = ?, life = ?, chaos = ?, harmony = ?, creation = ?, guardian = ?" . $customFields . " WHERE AccountID = ?", [$zen, $bless, $soul, $life, $chaos, $harmony, $creation, $guardian, $accountInfo[_CLMN_USERNM_]]);
                    if ($update1) {
                        message("success", "Web bank for account " . $accountInfo[_CLMN_USERNM_] . " was updated successfully.");
                        $fp = fopen(__ROOT_DIR__ . "__logs/admincp_" . date("Y-m-d", time()) . ".log", "ab");
                        if ($fp) {
                            $logData = "[Zen: " . $oldBalance["zen"] . "->" . $zen . "]";
                            $logData .= " [Bless: " . $oldBalance["bless"] . "->" . $bless . "]";
                            $logData .= " [Soul: " . $oldBalance["soul"] . "->" . $soul . "]";
                            $logData .= " [Life: " . $oldBalance["life"] . "->" . $life . "]";
                            $logData .= " [Chaos: " . $oldBalance["chaos"] . "->" . $chaos . "]";
                            $logData .= " [Harmony: " . $oldBalance["harmony"] . "->" . $harmony . "]";
                            $logData .= " [Creation: " . $oldBalance["creation"] . "->" . $creation . "]";
                            $logData .= " [Guardian: " . $oldBalance["guardian"] . "->" . $guardian . "]";
                            foreach ($customitems as $thisItem) {
                                $dbName = str_replace(" ", "_", $thisItem["name"]);
                                $logData .= " [" . $thisItem["name"] . ": " . $oldBalance[$dbName] . "->" . $_POST[$dbName] . "]";
                            }
                            fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] [Username: " . $_SESSION["username"] . "] Updated web bank balance on account \"" . $accountInfo[_CLMN_USERNM_] . "\" " . $logData . PHP_EOL);
                            fclose($fp);
                        }
                    } else {
                        message("success", "Could not update web bank information for account " . $accountInfo[_CLMN_USERNM_] . ".");
                    }
                }
            } else {
                message("error", "All values must be numbers.");
            }
        }
        echo "<h1 class=\"page-header\">Account Information: <small>" . $accountInfo[_CLMN_USERNM_] . "</small></h1>";
        echo "<div class=\"row\"><div class=\"col-md-6\">";
        if ($accountInfoConfig["showGeneralInfo"]) {
            if (config("SQL_USE_2_DB", true)) {
                $vipInfo = $dB2->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$accountInfo[_CLMN_USERNM_]]);
            } else {
                $vipInfo = $dB->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$accountInfo[_CLMN_USERNM_]]);
            }
            if (date("Y-m-d H:i:s", time()) < $vipInfo["Date"]) {
                if ($vipInfo["Type"] == 1) {
                    $type = "Bronze";
                } else {
                    if ($vipInfo["Type"] == 2) {
                        $type = "Silver";
                    } else {
                        if ($vipInfo["Type"] == 3) {
                            $type = "Gold";
                        } else {
                            if ($vipInfo["Type"] == 4) {
                                $type = "Platinum";
                            } else {
                                $type = "Unknown";
                            }
                        }
                    }
                }
                $vip = $type . ", expires on " . date($config["time_date_format"], strtotime($vipInfo["Date"])) . " <a href=\"index.php?module=accountinfo&id=" . $_GET["id"] . "&delete=vip\" class=\"btn btn-danger\" title=\"Remove VIP\"><i class=\"fa fa-remove\"></i></a>";
            } else {
                $vip = "none";
            }
            echo "<div class=\"panel panel-primary\"><div class=\"panel-heading\">General Information</div><div class=\"panel-body\">";
            $isBanned = $accountInfo[_CLMN_BLOCCODE_] == 0 ? "<span class=\"label label-success\">Active</span>" : "<span class=\"label label-danger\">Banned</span>";
            echo "<table class=\"table table-no-border table-hover\"><tr><th>ID:</th>";
            echo "<td>" . $accountInfo[_CLMN_MEMBID_] . "</td>";
            echo "</tr><tr><th>Username:</th>";
            echo "<td>" . $accountInfo[_CLMN_USERNM_] . "</td>";
            echo "</tr><tr><th>Email:</th>";
            echo "<td>" . $accountInfo[_CLMN_EMAIL_] . "</td>";
            echo "</tr><tr><th>Status:</th>";
            echo "<td>" . $isBanned . "</td>";
            echo "</tr><tr><th>VIP:</th>";
            echo "<td>" . $vip . "</td>";
            echo "</tr></table></div></div>";
        }
        if ($accountInfoConfig["showIpInfo"]) {
            if (config("SQL_USE_2_DB", true)) {
                $checkHistory = $dB2->query_fetch("SELECT TOP 10 * FROM ConnectionHistory WHERE AccountID = '" . $accountInfo[_CLMN_USERNM_] . "' AND State = 'Connect'");
            } else {
                $checkHistory = $dB->query_fetch("SELECT TOP 10 * FROM ConnectionHistory WHERE AccountID = '" . $accountInfo[_CLMN_USERNM_] . "' AND State = 'Connect'");
            }
            echo "<div class=\"panel panel-default\"><div class=\"panel-heading\">Account's latest 10 IP Address & HWID</div><div class=\"panel-body\">";
            if (is_array($checkHistory)) {
                echo "<table class=\"table table-no-border table-hover\">";
                foreach ($checkHistory as $accountIp) {
                    echo "<tr>";
                    echo "<td><a href=\"http://whatismyipaddress.com/ip/" . urlencode($accountIp["IP"]) . "\" target=\"_blank\">" . $accountIp["IP"] . "</a></td>";
                    echo "<td>" . $accountIp["HWID"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                message("warning", "No IP address found.", " ");
            }
            echo "</div></div>";
        }
        echo "</div><div class=\"col-md-6\">";
        if ($accountInfoConfig["showStatusInfo"]) {
            $statusdb = config("SQL_USE_2_DB", true) ? $dB2 : $dB;
            $statusData = $statusdb->query_fetch_single("SELECT * FROM " . _TBL_MS_ . " WHERE " . _CLMN_MS_MEMBID_ . " = ?", [$accountInfo[_CLMN_USERNM_]]);
            echo "<div class=\"panel panel-info\"><div class=\"panel-heading\">Status Information</div><div class=\"panel-body\">";
            if (is_array($statusData)) {
                $onlineStatus = $statusData[_CLMN_CONNSTAT_] == 1 ? "<span class=\"label label-success\">Online</span>" : "<span class=\"label label-danger\">Offline</span>";
                echo "<table class=\"table table-no-border table-hover\"><tr><td>Status:</td>";
                echo "<td>" . $onlineStatus . "</td>";
                echo "</tr><tr><td>Server:</td>";
                echo "<td>" . $statusData[_CLMN_MS_GS_] . "</td>";
                echo "</tr></table>";
            } else {
                message("warning", "No data found in <strong>" . _TBL_MS_ . "</strong> for this account.", " ");
            }
            echo "</div></div>";
        }
        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
            $balance1 = $dB2->query_fetch_single("SELECT * FROM MEMB_CREDITS WHERE memb___id = ?", [$accountInfo[_CLMN_USERNM_]]);
        } else {
            $balance1 = $dB->query_fetch_single("SELECT * FROM MEMB_CREDITS WHERE memb___id = ?", [$accountInfo[_CLMN_USERNM_]]);
        }
        $balance2 = $dB->query_fetch_single("SELECT * FROM T_InGameShop_Point WHERE AccountID = ?", [$accountInfo[_CLMN_USERNM_]]);
        echo "\r\n        <form method=\"post\" action=\"\" class=\"form-horizontal\">\r\n            <div id=\"balance\" class=\"modal fade\" role=\"dialog\">\r\n                <div class=\"modal-dialog modal-lg\">\r\n                    <div class=\"modal-content\">\r\n                        <div class=\"modal-header\">\r\n                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\r\n                            <h4 class=\"modal-title\">Edit Balance :: " . $accountInfo[_CLMN_USERNM_] . "</h4>\r\n                        </div>\r\n                        <div class=\"modal-body\">\r\n                            <div style=\"height: 350px;\">\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"platinum\">Platinum Coins:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <input type=\"text\" name=\"platinum\" id=\"platinum\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($balance1["platinum"]) . "\">\r\n                                        <span id=\"platinumHelp\" class=\"help-block\"></span>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"gold\">Gold Coins:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <input type=\"text\" name=\"gold\" id=\"gold\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($balance1["gold"]) . "\">\r\n                                        <span id=\"goldHelp\" class=\"help-block\"></span>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"silver\">Silver Coins:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <input type=\"text\" name=\"silver\" id=\"silver\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($balance1["silver"]) . "\">\r\n                                        <span id=\"silverHelp\" class=\"help-block\"></span>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"wcoinc\">WCoinC:</label>\r\n                                    <div class=\"col-sm-8\">";
        if (100 <= config("server_files_season", true)) {
            echo "<input type=\"text\" name=\"wcoinc\" id=\"wcoinc\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($balance2["WCoin"]) . "\">";
        } else {
            echo "<input type=\"text\" name=\"wcoinc\" id=\"wcoinc\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($balance2["WCoinC"]) . "\">";
        }
        echo "\r\n                                        <span id=\"wcoincHelp\" class=\"help-block\"></span>\r\n                                    </div>\r\n                                </div>";
        if (config("server_files_season", true) == 60) {
            echo "\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"wcoinp\">WCoinP:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <input type=\"text\" name=\"wcoinp\" id=\"wcoinp\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($balance2["WCoinP"]) . "\">\r\n                                        <span id=\"wcoinpHelp\" class=\"help-block\"></span>\r\n                                    </div>\r\n                                </div>";
        }
        echo "\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"col-sm-4 control-label\" for=\"gp\">GoblinPoint:</label>\r\n                                    <div class=\"col-sm-8\">\r\n                                        <input type=\"text\" name=\"gp\" id=\"gp\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($balance2["GoblinPoint"]) . "\">\r\n                                        <span id=\"gpHelp\" class=\"help-block\"></span>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                        <div class=\"modal-footer\">\r\n                            <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\r\n                            <input type=\"submit\" name=\"save_balance\" class=\"btn btn-success\" value=\"Save\"/>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </form>";
        echo "<div class=\"panel panel-primary\"><div class=\"panel-heading\">Balance Information</div><div class=\"panel-body\"><table class=\"table table-no-border table-hover\"><tr><td>Platinum Coins:</td>";
        echo "<td><b>" . number_format($balance1["platinum"]) . "</b> (" . number_format($balance1["platinum_used"]) . " used)</td>";
        echo "</tr><tr><td>Gold Coins:</td>";
        echo "<td><b>" . number_format($balance1["gold"]) . "</b> (" . number_format($balance1["gold_used"]) . " used)</td>";
        echo "</tr><tr><td>Silver Coins:</td>";
        echo "<td><b>" . number_format($balance1["silver"]) . "</b> (" . number_format($balance1["silver_used"]) . " used)</td>";
        echo "</tr><tr><td>WCoinC:</td>";
        if (100 <= config("server_files_season", true)) {
            echo "<td><b>" . number_format($balance2["WCoin"]) . "</b></td>";
        } else {
            echo "<td><b>" . number_format($balance2["WCoinC"]) . "</b></td>";
        }
        echo "</tr>";
        if (config("server_files_season", true) == 60) {
            echo "<tr><td>WCoinP:</td>";
            echo "<td><b>" . number_format($balance2["WCoinP"]) . "</b></td>";
            echo "</tr>";
        }
        echo "<tr><td>GoblinPoint:</td>";
        echo "<td><b>" . number_format($balance2["GoblinPoint"]) . "</b></td>";
        echo "</tr></table><button type=\"button\" class=\"btn btn-default btn-sm\" data-toggle=\"modal\" data-target=\"#balance\"><i class=\"fa fa-edit\"></i> Edit</button></div></div>";
        if ($accountInfoConfig["showCharacters"]) {
            $Character = new Character();
            $accountCharacters = $Character->AccountCharacter($accountInfo[_CLMN_USERNM_]);
            echo "<div class=\"panel panel-default\"><div class=\"panel-heading\">Characters</div><div class=\"panel-body\">";
            if (is_array($accountCharacters)) {
                echo "<table class=\"table table-no-border table-hover\">";
                foreach ($accountCharacters as $characterName) {
                    echo "<tr>";
                    echo "<td><a href=\"" . admincp_base("editcharacter&name=" . hex_encode($characterName)) . "\">" . $common->replaceHtmlSymbols($characterName) . "</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                message("warning", "No characters found.", " ");
            }
            echo "</div></div>";
        }
        echo "</div></div>";
        $bank = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_WEB_BANK WHERE AccountID = ?", [$accountInfo[_CLMN_USERNM_]]);
        $customitems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEB_BANK_CUSTOM");
        echo "\r\n        <form method=\"post\" action=\"\" class=\"form-horizontal\">\r\n            <div id=\"webbank\" class=\"modal fade\" role=\"dialog\">\r\n                <div class=\"modal-dialog modal-lg\">\r\n                    <div class=\"modal-content\">\r\n                        <div class=\"modal-header\">\r\n                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\r\n                            <h4 class=\"modal-title\">Edit Web Bank :: " . $accountInfo[_CLMN_USERNM_] . "</h4>\r\n                        </div>\r\n                        <div class=\"modal-body\">\r\n                            <div style=\"min-height: 350px;\">\r\n                                <div class=\"row\">\r\n                                    <div class=\"col-md-6\">\r\n                                        <div class=\"form-group\">\r\n                                            <label class=\"col-sm-4 control-label\" for=\"zen\">Zen:</label>\r\n                                            <div class=\"col-sm-8\">\r\n                                                <input type=\"text\" name=\"zen\" id=\"zen\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($bank["zen"]) . "\">\r\n                                                <span id=\"zenHelp\" class=\"help-block\"></span>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                            <label class=\"col-sm-4 control-label\" for=\"soul\">Jewel of Soul:</label>\r\n                                            <div class=\"col-sm-8\">\r\n                                                <input type=\"text\" name=\"soul\" id=\"soul\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($bank["soul"]) . "\">\r\n                                                <span id=\"soulHelp\" class=\"help-block\"></span>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                            <label class=\"col-sm-4 control-label\" for=\"chaos\">Jewel of Chaos:</label>\r\n                                            <div class=\"col-sm-8\">\r\n                                                <input type=\"text\" name=\"chaos\" id=\"chaos\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($bank["chaos"]) . "\">\r\n                                                <span id=\"chaosHelp\" class=\"help-block\"></span>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                            <label class=\"col-sm-4 control-label\" for=\"creation\">Jewel of Creation:</label>\r\n                                            <div class=\"col-sm-8\">\r\n                                                <input type=\"text\" name=\"creation\" id=\"creation\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($bank["creation"]) . "\">\r\n                                                <span id=\"creationHelp\" class=\"help-block\"></span>\r\n                                            </div>\r\n                                        </div>";
        $i = 1;
        if (is_array($customitems)) {
            foreach ($customitems as $thisItem) {
                $dbName = str_replace(" ", "_", $thisItem["name"]);
                if ($i % 2 != 0) {
                    echo "\r\n                                        <div class=\"form-group\">\r\n                                            <label class=\"col-sm-4 control-label\" for=\"" . $dbName . "\">" . $thisItem["name"] . ":</label>\r\n                                            <div class=\"col-sm-8\">\r\n                                                <input type=\"text\" name=\"" . $dbName . "\" id=\"" . $dbName . "\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($bank[$dbName]) . "\">\r\n                                                <span id=\"" . $dbName . "Help\" class=\"help-block\"></span>\r\n                                            </div>\r\n                                        </div>";
                }
                $i++;
            }
        }
        echo "\r\n                                    </div>\r\n                                    <div class=\"col-md-6\">\r\n                                        <div class=\"form-group\">\r\n                                            <label class=\"col-sm-4 control-label\" for=\"bless\">Jewel of Bless:</label>\r\n                                            <div class=\"col-sm-8\">\r\n                                                <input type=\"text\" name=\"bless\" id=\"bless\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($bank["bless"]) . "\">\r\n                                                <span id=\"blessHelp\" class=\"help-block\"></span>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                            <label class=\"col-sm-4 control-label\" for=\"life\">Jewel of Life:</label>\r\n                                            <div class=\"col-sm-8\">\r\n                                                <input type=\"text\" name=\"life\" id=\"life\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($bank["life"]) . "\">\r\n                                                <span id=\"lifeHelp\" class=\"help-block\"></span>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                            <label class=\"col-sm-4 control-label\" for=\"harmony\">Jewel of Harmony:</label>\r\n                                            <div class=\"col-sm-8\">\r\n                                                <input type=\"text\" name=\"harmony\" id=\"harmony\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($bank["harmony"]) . "\">\r\n                                                <span id=\"harmonyHelp\" class=\"help-block\"></span>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\"form-group\">\r\n                                            <label class=\"col-sm-4 control-label\" for=\"guardian\">Jewel of Guardian:</label>\r\n                                            <div class=\"col-sm-8\">\r\n                                                <input type=\"text\" name=\"guardian\" id=\"guardian\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($bank["guardian"]) . "\">\r\n                                                <span id=\"guardianHelp\" class=\"help-block\"></span>\r\n                                            </div>\r\n                                        </div>";
        $i = 1;
        if (is_array($customitems)) {
            foreach ($customitems as $thisItem) {
                $dbName = str_replace(" ", "_", $thisItem["name"]);
                if ($i % 2 == 0) {
                    echo "\r\n                                        <div class=\"form-group\">\r\n                                            <label class=\"col-sm-4 control-label\" for=\"" . $dbName . "\">" . $thisItem["name"] . ":</label>\r\n                                            <div class=\"col-sm-8\">\r\n                                                <input type=\"text\" name=\"" . $dbName . "\" id=\"" . $dbName . "\" class=\"form-control\" aria-describedby=\"helpBlock\" value=\"" . intval($bank[$dbName]) . "\">\r\n                                                <span id=\"" . $dbName . "Help\" class=\"help-block\"></span>\r\n                                            </div>\r\n                                        </div>";
                }
                $i++;
            }
        }
        echo "\r\n                                    </div>\r\n                                </div>   \r\n                            </div>\r\n                        </div>\r\n                        <div class=\"modal-footer\">\r\n                            <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\r\n                            <input type=\"submit\" name=\"save_webbank\" class=\"btn btn-success\" value=\"Save\"/>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </form><div class=\"row\"><div class=\"col-md-12\"><div class=\"panel panel-primary\"><div class=\"panel-heading\">Web Bank Information</div><div class=\"panel-body\"><table class=\"table table-no-border table-hover\"><tr><td width=\"25%\">Zen:</td>";
        echo "<td width=\"25%\"><b>" . number_format($bank["zen"]) . "</b></td>";
        echo "<td width=\"25%\">Jewel of Bless:</td>";
        echo "<td width=\"25%\"><b>" . number_format($bank["bless"]) . "</b></td>";
        echo "</tr><tr><td width=\"25%\">Jewel of Soul:</td>";
        echo "<td width=\"25%\"><b>" . number_format($bank["soul"]) . "</b></td>";
        echo "<td width=\"25%\">Jewel of Life:</td>";
        echo "<td width=\"25%\"><b>" . number_format($bank["life"]) . "</b></td>";
        echo "</tr><tr><td width=\"25%\">Jewel of Chaos:</td>";
        echo "<td width=\"25%\"><b>" . number_format($bank["chaos"]) . "</b></td>";
        echo "<td width=\"25%\">Jewel of Harmony:</td>";
        echo "<td width=\"25%\"><b>" . number_format($bank["harmony"]) . "</b></td>";
        echo "</tr><tr><td width=\"25%\">Jewel of Creation:</td>";
        echo "<td width=\"25%\"><b>" . number_format($bank["creation"]) . "</b></td>";
        echo "<td width=\"25%\">Jewel of Guardian:</td>";
        echo "<td width=\"25%\"><b>" . number_format($bank["guardian"]) . "</b></td>";
        echo "</tr>";
        $i = 1;
        if (is_array($customitems)) {
            foreach ($customitems as $thisItem) {
                $dbName = str_replace(" ", "_", $thisItem["name"]);
                if ($i % 2 != 0) {
                    echo "<tr>";
                }
                echo "\r\n                    <td>" . $thisItem["name"] . "</td>\r\n                    <td><b>" . number_format($bank[$dbName]) . "</b></td>";
                if ($i % 2 == 0) {
                    echo "</tr>";
                }
                $i++;
            }
        }
        echo "</table><button type=\"button\" class=\"btn btn-default btn-sm\" data-toggle=\"modal\" data-target=\"#webbank\"><i class=\"fa fa-edit\"></i> Edit</button></div></div></div></div><div class=\"row\"><div class=\"col-md-12\">";
        $items = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY WHERE AccountID = ? AND status = ?", [$accountInfo[_CLMN_USERNM_], 0]);
        echo "<div class=\"panel panel-primary\"><div class=\"panel-heading\">Items Inventory Information</div><div class=\"panel-body\"><table class=\"table table-no-border table-hover\"><tr><th>#</th><th>Item</th><th>Price</th><th>Type</th><th>Date</th><th>Action</th></tr>";
        $Market = new Market();
        $Items = new Items();
        echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
        $i = 1;
        foreach ($items as $thisItem) {
            $itemInfo = $Items->ItemInfo($thisItem["item"]);
            switch ($thisItem["price_type"]) {
                case "1":
                    $price = number_format($thisItem["price"]) . " Platinum Coins";
                    break;
                case "2":
                    $price = number_format($thisItem["price"]) . " Gold Coins";
                    break;
                case "4":
                    $price = number_format($thisItem["price"]) . " Silver Coins";
                    break;
                case "10":
                    $price = number_format($thisItem["price"]) . " Zen";
                    break;
                case "11":
                    $price = number_format($thisItem["price"]) . " Jewel of Bless";
                    break;
                case "12":
                    $price = number_format($thisItem["price"]) . " Jewel of Soul";
                    break;
                case "13":
                    $price = number_format($thisItem["price"]) . " Jewel of Life";
                    break;
                case "14":
                    $price = number_format($thisItem["price"]) . " Jewel of Chaos";
                    break;
                case "15":
                    $price = number_format($thisItem["price"]) . " Jewel of Harmony";
                    break;
                case "16":
                    $price = number_format($thisItem["price"]) . " Jewel of Creation";
                    break;
                case "17":
                    $price = number_format($thisItem["price"]) . " Jewel of Guardian";
                    break;
                default:
                    $price = "none";
                    $luck = "";
                    $skill = "";
                    $option = "";
                    $exl = "";
                    $ancsetopt = "";
                    if ($itemInfo["level"]) {
                        $itemInfo["level"] = " +" . $itemInfo["level"];
                    } else {
                        $itemInfo["level"] = NULL;
                    }
                    if ($itemInfo["luck"]) {
                        $luck = "<br><font color=#9aadd5>" . $itemInfo["luck"] . "</font>";
                    }
                    if ($itemInfo["skill"]) {
                        $skill = "<br><font color=#9aadd5>" . $itemInfo["skill"] . "</font>";
                    }
                    if ($itemInfo["opt"]) {
                        $option = "<font color=#9aadd5>" . $itemInfo["opt"] . "</font>";
                    }
                    if ($itemInfo["exl"]) {
                        $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $itemInfo["exl"]) . "</font>";
                    }
                    if ($itemInfo["ancsetopt"]) {
                        $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $itemInfo["ancsetopt"]) . "</font>";
                    }
                    if ($thisItem["type"] == "1") {
                        $type = "Webshop Purchase";
                    } else {
                        if ($thisItem["type"] == "2") {
                            $type = "Webshop Gift from " . $thisItem["from"];
                        } else {
                            if ($thisItem["type"] == "3") {
                                $type = "Promo Code Gift";
                            } else {
                                if ($thisItem["type"] == "4") {
                                    $type = "Market Purchase";
                                } else {
                                    if ($thisItem["type"] == "5") {
                                        $type = "Market Return";
                                    }
                                }
                            }
                        }
                    }
                    $exl = str_replace("'", "\\'", $exl);
                    if ($thisItem["type"] == "1") {
                        $type = "Webshop Purchase";
                    } else {
                        if ($thisItem["type"] == "2") {
                            $type = "Webshop Gift from " . $thisItem["from"];
                        } else {
                            if ($thisItem["type"] == "3") {
                                $type = "Promo Code Gift";
                            } else {
                                if ($thisItem["type"] == "4") {
                                    $type = "Market Purchase";
                                } else {
                                    if ($thisItem["type"] == "5") {
                                        $type = "Market Return";
                                    }
                                }
                            }
                        }
                    }
                    echo "<tr>";
                    echo "<td>" . $i . "</td>";
                    echo "<td align=\"left\" style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=yellow><br>Serial: " . $itemInfo["sn2"] . $itemInfo["sn"] . "</font><br><font color=white><br>Durability: " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\" <img src=\"" . $itemInfo["thumb"] . "\" class=\"m\"><b>" . $itemInfo["name"] . "</b></td>";
                    echo "<td>" . $price . "</td>";
                    echo "<td>" . $type . "</td>";
                    echo "<td>" . date($config["time_date_format"], strtotime($thisItem["date"])) . "</td>";
                    echo "<td><a class=\"btn btn-danger btn-sm\" href=\"" . admincp_base("accountinfo&id=" . $_GET["id"] . "&delete_item=" . $thisItem["id"] . "") . "\" onClick=\"if(confirm('Do you really want to delete this item?')) return true; else return false;\"><i class=\"fa fa-trash\"></i> delete</a></td>";
                    echo "</tr>";
                    $i++;
            }
        }
        echo "</table></div></div></div></div><h2>Edit Account</h2><div class=\"row\"><div class=\"col-md-6\"><div class=\"panel panel-default\"><div class=\"panel-heading\">Change Account's Password</div><div class=\"panel-body\"><form role=\"form\" method=\"post\"><input type=\"hidden\" name=\"action\" value=\"changepassword\"/><div class=\"form-group\"><label for=\"input_1\">New Password:</label><input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"changepassword_newpw\" placeholder=\"New password\"></div><div class=\"checkbox\"><label><input type=\"checkbox\" name=\"editaccount_sendmail\" value=\"1\" checked> Send email to user about this change.</label></div><button type=\"submit\" name=\"editaccount_submit\" class=\"btn btn-success\" value=\"ok\">Change Password</button></form></div></div></div><div class=\"col-md-6\"><div class=\"panel panel-default\"><div class=\"panel-heading\">Change Account's Email</div><div class=\"panel-body\"><form role=\"form\" method=\"post\"><input type=\"hidden\" name=\"action\" value=\"changeemail\"/><div class=\"form-group\"><label for=\"input_2\">New Email:</label><input type=\"email\" class=\"form-control\" id=\"input_2\" name=\"changeemail_newemail\" placeholder=\"New email address\"></div><div class=\"checkbox\"><label><input type=\"checkbox\" name=\"editaccount_sendmail\" value=\"1\" checked> Send email to user about this change.</label></div><button type=\"submit\" name=\"editaccount_submit\" class=\"btn btn-success\" value=\"ok\">Change Email</button></form></div></div></div></div>";
        if (date("Y-m-d H:i:s", time()) < $vipInfo["Date"]) {
            echo "<h2>Edit VIP</h2><div class=\"row\"><div class=\"col-md-6\"><div class=\"panel panel-default\"><div class=\"panel-heading\">VIP Status</div><div class=\"panel-body\"><form role=\"form\" method=\"post\"><input type=\"hidden\" name=\"action\" value=\"editvip\"/><div class=\"form-group\"><label for=\"input_1\">Type:</label><select name=\"vip_type\" class=\"form-control\">";
            if ($vipInfo["Type"] == 1) {
                echo "<option value=\"1\" selected=\"selected\">Bronze</option>";
            } else {
                echo "<option value=\"1\">Bronze</option>";
            }
            if ($vipInfo["Type"] == 2) {
                echo "<option value=\"2\" selected=\"selected\">Silver</option>";
            } else {
                echo "<option value=\"2\">Silver</option>";
            }
            if ($vipInfo["Type"] == 3) {
                echo "<option value=\"3\" selected=\"selected\">Gold</option>";
            } else {
                echo "<option value=\"3\">Gold</option>";
            }
            if ($vipInfo["Type"] == 4) {
                echo "<option value=\"4\" selected=\"selected\">Platinum</option>";
            } else {
                echo "<option value=\"4\">Platinum</option>";
            }
            echo "</select></div><div class=\"form-group\"><label for=\"input_1\">Expiration Date (YYYY-mm-dd HH:mm:ss):</label>";
            echo "<input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"vip_date\" placeholder=\"2016-12-31 23:59:00\" value=\"" . date("Y-m-d H:i:s", strtotime($vipInfo["Date"])) . "\">";
            echo "</div><button type=\"submit\" name=\"editvip_submit\" class=\"btn btn-success\" value=\"ok\">Edit VIP</button></form></div></div></div></div>";
        } else {
            echo "<h2>Add VIP</h2><div class=\"row\"><div class=\"col-md-6\"><div class=\"panel panel-default\"><div class=\"panel-heading\">VIP Status</div><div class=\"panel-body\"><form role=\"form\" method=\"post\"><input type=\"hidden\" name=\"action\" value=\"editvip\"/><div class=\"form-group\"><label for=\"input_1\">Type:</label><select name=\"vip_type\" class=\"form-control\"><option value=\"1\">Bronze</option><option value=\"2\">Silver</option><option value=\"3\">Gold</option><option value=\"4\">Platinum</option></select></div><div class=\"form-group\"><label for=\"input_1\">Expiration Date (YYYY-mm-dd HH:mm:ss):</label>";
            echo "<input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"vip_date\" placeholder=\"2016-12-31 23:59:00\" value=\"" . date("Y-m-d H:i:s", strtotime("+7 days")) . "\">";
            echo "</div><button type=\"submit\" name=\"addvip_submit\" class=\"btn btn-success\" value=\"ok\">Add VIP</button></form></div></div></div></div>";
        }
    } catch (Exception $ex) {
        echo "<h1 class=\"page-header\">Account Information</h1>";
        message("error", $ex->getMessage());
    }
} else {
    echo "<h1 class=\"page-header\">Account Information</h1>";
    message("error", "Please provide a valid user id.");
}

?>