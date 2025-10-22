<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    $accountInfo = $common->accountInformation($_SESSION["userid"]);
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_3", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            if ($accountInfo) {
                $accountLoginInfo = $common->accountLoginInformation($_SESSION["username"]);
                $accountBalance = $common->accountBalance($_SESSION["username"]);
                if ($common->accountOnline($_SESSION["username"])) {
                    $accountOnlineStatus = "<span class=\"online\">" . lang("myaccount_txt_9", true) . "</span>";
                } else {
                    $accountOnlineStatus = "<span class=\"offline\">" . lang("myaccount_txt_10", true) . "</span>";
                }
                if ($accountInfo[_CLMN_BLOCCODE_] == 1) {
                    $accountStatus = "<span class=\"blocked\">" . lang("myaccount_txt_8", true) . "</span>";
                } else {
                    $accountStatus = "<span class=\"active\">" . lang("myaccount_txt_7", true) . "</span>";
                }
                if ($accountLoginInfo["ConnectTM"] == NULL || empty($accountLoginInfo["ConnectTM"])) {
                    $accountLoginInfo["ConnectTM"] = "never";
                }
                if ($accountLoginInfo[_CLMN_MS_IP_] == NULL || empty($accountLoginInfo[_CLMN_MS_IP_])) {
                    $accountLoginInfo[_CLMN_MS_IP_] = "none";
                }
                if ($accountLoginInfo[_CLMN_MS_GS_] == NULL || empty($accountLoginInfo[_CLMN_MS_GS_])) {
                    $accountLoginInfo[_CLMN_MS_GS_] = "none";
                }
                $regDate = date($config["date_format"], strtotime($accountInfo["appl_days"]));
                $loginDate = date($config["time_date_format"], strtotime($accountLoginInfo["ConnectTM"]));
                $Ticket = new Ticket();
                $tickets = $Ticket->getMyTicketsFull($_SESSION["username"]);
                $ticketNotification = "";
                if (is_array($tickets)) {
                    foreach ($tickets as $ticket) {
                        if ($ticket["lastSeen"] < $ticket["updated"]) {
                            $ticketNotification = lang("tickets_txt_25", true);
                        }
                    }
                }
                $BugTracker = new BugTracker();
                $reports = $BugTracker->getMyReportsFull($_SESSION["username"]);
                $trackerNotification = "";
                if (is_array($reports)) {
                    foreach ($reports as $report) {
                        if ($report["lastSeen"] < $report["updated"]) {
                            $trackerNotification = lang("bugtracker_txt_42", true);
                        }
                    }
                }
                $vipConfigs = loadConfigurations("usercp.vip");
                if ($vipConfigs["show_in_usercp"] == "1") {
                    if (config("SQL_USE_2_DB", true)) {
                        $vipData = $dB2->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$_SESSION["username"]]);
                    } else {
                        $vipData = $dB->query_fetch_single("SELECT * FROM T_VIPList WHERE AccountID = ?", [$_SESSION["username"]]);
                    }
                    if (!is_array($vipData) || $vipData["Date"] == NULL || $vipData["Type"] == NULL) {
                        $vipStatus = lang("vip_txt_39", true);
                        $isActiveVip = false;
                    } else {
                        if (time() < strtotime($vipData["Date"])) {
                            switch ($vipData["Type"]) {
                                case "1":
                                    $vipStatus = lang("vip_txt_18", true);
                                    break;
                                case "2":
                                    $vipStatus = lang("vip_txt_19", true);
                                    break;
                                case "3":
                                    $vipStatus = lang("vip_txt_20", true);
                                    break;
                                case "4":
                                    $vipStatus = lang("vip_txt_21", true);
                                    break;
                                default:
                                    $date = date($config["time_date_format"], strtotime($vipData["Date"]));
                                    $vipStatus .= ", " . lang("vip_txt_24", true) . " " . $date;
                                    $isActiveVip = true;
                            }
                        } else {
                            $vipStatus = lang("vip_txt_25", true);
                            $isActiveVip = false;
                        }
                    }
                }
                echo "\r\n            <div class=\"row usercp_info\">\r\n                <div class=\"col-xs-12 col-sm-6\">\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("myaccount_txt_1", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . $accountStatus . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("myaccount_txt_2", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . $accountInfo[_CLMN_USERNM_] . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("myaccount_txt_4", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        ********** (<a href=\"" . __BASE_URL__ . "usercp/mypassword/\">" . lang("myaccount_txt_6", true) . "</a>)\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("myaccount_txt_3", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . $accountInfo[_CLMN_EMAIL_] . " (<a href=\"" . __BASE_URL__ . "usercp/myemail/\">" . lang("myaccount_txt_6", true) . "</a>)\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("myaccount_txt_87", true) . "\r\n                    </div>";
                if ($vipConfigs["show_in_usercp"] == "1") {
                    echo "\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . $vipStatus . "\r\n                    </div>";
                }
                echo "\r\n                </div>\r\n                <div class=\"col-xs-12 col-sm-6\">\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("myaccount_txt_5", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . $accountOnlineStatus . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("myaccount_txt_20", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . $accountLoginInfo[_CLMN_MS_GS_] . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("myaccount_txt_17", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . $loginDate . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("myaccount_txt_18", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . $accountLoginInfo[_CLMN_MS_IP_] . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("myaccount_txt_19", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . $regDate . "\r\n                    </div>\r\n                </div>";
                $currenciesTotal = 0;
                if ($config["use_platinum"]) {
                    $currenciesTotal++;
                }
                if ($config["use_gold"]) {
                    $currenciesTotal++;
                }
                if ($config["use_silver"]) {
                    $currenciesTotal++;
                }
                if (0 < $currenciesTotal) {
                    echo "\r\n                <div class=\"col-xs-12 col-sm-6 usercp_info_space\">";
                    if ($config["use_platinum"]) {
                        echo "\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("currency_platinum", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . number_format($accountBalance["platinum"]) . "\r\n                    </div>";
                    }
                    if ($config["use_gold"]) {
                        echo "\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("currency_gold", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . number_format($accountBalance["gold"]) . "\r\n                    </div>";
                    }
                    if ($config["use_silver"]) {
                        echo "\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("currency_silver", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . number_format($accountBalance["silver"]) . "\r\n                    </div>";
                    }
                    echo "\r\n                </div>";
                }
                $cashShop = $dB->query_fetch_single("SELECT * FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                echo "\r\n                <div class=\"col-xs-12 col-sm-6 usercp_info_space\">";
                if (100 <= config("server_files_season", true)) {
                    echo "\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("currency_wcoinc", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . number_format($cashShop["WCoin"]) . "\r\n                    </div>";
                } else {
                    echo "\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("currency_wcoinc", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . number_format($cashShop["WCoinC"]) . "\r\n                    </div>";
                    if (config("server_files_season", true) < 70) {
                        echo "\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("currency_wcoinp", true) . "\r\n                    </div>";
                    }
                    echo "\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . number_format($cashShop["WCoinP"]) . "\r\n                    </div>";
                }
                echo "\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . lang("currency_gp", true) . "\r\n                    </div>\r\n                    <div class=\"col-xs-6 usercp_info_text\">\r\n                        " . number_format($cashShop["GoblinPoint"]) . "\r\n                    </div>";
                echo "\r\n                </div>\r\n            </div>";
                if ($ticketNotification != NULL) {
                    echo "\r\n            <div style=\"padding-top: 20px;\">";
                    message("info", $ticketNotification);
                    echo "\r\n            </div>";
                }
                if ($trackerNotification != NULL) {
                    echo "\r\n            <div style=\"padding-top: 20px;\">";
                    message("info", $trackerNotification);
                    echo "\r\n            </div>";
                }
                if ($accountInfo[_CLMN_BLOCCODE_] == 1) {
                    echo "\r\n            <div style=\"padding-top: 20px;\">";
                    message("info", lang("myaccount_txt_82", true));
                    echo "\r\n            </div>";
                }
                $main_menu = mconfig("main_menu");
                $quick_menu = mconfig("quick_menu");
                $userCP = new UserCP();
                $main_menu_sections = $userCP->create_main_manu($main_menu);
                $quick_menu_modules = $userCP->create_quick_menu($quick_menu);
                echo "\r\n            <div class=\"row usercp_menu\">\r\n                <div class=\"col-xs-12 col-sm-8 col-md-9\">";
                foreach ($main_menu_sections as $section) {
                    if ($section["active"]) {
                        $name = "";
                        if ($section["name"] == "myaccount_txt_21" || $section["name"] == "myaccount_txt_30" || $section["name"] == "myaccount_txt_55") {
                            $name = lang($section["name"], true);
                        } else {
                            $name = $section["name"];
                        }
                        echo "\r\n                    <div class=\"col-xs-12 usercp_main\">\r\n                        <div class=\"usercp_main_section\">" . $name . "</div>\r\n                    </div>";
                        foreach ($section["modules"] as $module) {
                            if (!$module["hidden"]) {
                                $active = true;
                                $name = "";
                                $desc = "";
                                if ($module["custom"]) {
                                    $name = $module["name"];
                                    $desc = $module["desc"];
                                } else {
                                    loadModuleConfigs($module["config"]);
                                    $active = mconfig("active");
                                    $name = lang($module["name"], true);
                                    $desc = lang($module["desc"], true);
                                }
                                if ($active) {
                                    echo "\r\n                    <div class=\"col-xs-12 col-sm-12 col-md-6 usercp_main\">\r\n                        <a href=\"" . __BASE_URL__ . $module["module"] . "\">\r\n                            <div class=\"usercp_main_item\">\r\n                                <div class=\"usercp_main_item_icon\"><i class=\"" . $module["icon"] . "\"></i></div>\r\n                                <div class=\"usercp_main_item_title\">" . $name . "</div>\r\n                                <div class=\"usercp_main_item_desc\">" . $desc . "</div>\r\n                            </div>\r\n                        </a>\r\n                    </div>";
                                }
                            }
                        }
                    }
                }
                echo "  \r\n                </div>\r\n                <div class=\"col-xs-12 col-sm-4 col-md-3 usercp_side_menu\">";
                $General = new xGeneral();
                loadModuleConfigs("usercp.merchant");
                if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("merchant") && mconfig("active")) {
                    $merchants = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_MERCHANTS");
                    $canAccess = false;
                    if (is_array($merchants)) {
                        foreach ($merchants as $thisMerchant) {
                            if ($thisMerchant["AccountID"] == $_SESSION["username"] && $thisMerchant["active"] == "1") {
                                echo "<a href=\"" . __BASE_URL__ . "usercp/merchant\"><div class=\"col-xs-12 usercp_side_item special\">" . lang("myaccount_txt_64", true) . "</div></a>";
                            }
                        }
                    }
                }
                foreach ($quick_menu_modules as $module) {
                    if (!$module["hidden"]) {
                        loadModuleConfigs($module["config"]);
                        if (mconfig("active")) {
                            $classAtr = !empty($module["class"]) ? "" . $module["class"] . "" : "";
                            if ($module["module"] == "usercp/claimreward") {
                                $myrewards = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_CLAIM_REWARD WHERE AccountID = ? AND claimed = ? AND (expiration > ? OR expiration IS NULL)", [$_SESSION["username"], 0, date("Y-m-d H:i:s", time())]);
                                if (0 < $myrewards["count"]) {
                                    echo "<a href=\"" . __BASE_URL__ . $module["module"] . "\"><div class=\"col-xs-12 usercp_side_item special\">" . lang($module["name"], true) . " (" . $myrewards["count"] . ")</div></a>";
                                } else {
                                    echo "<a href=\"" . __BASE_URL__ . $module["module"] . "\"><div class=\"col-xs-12 usercp_side_item\">" . lang($module["name"], true) . "</div></a>";
                                }
                            } else {
                                echo "<a href=\"" . __BASE_URL__ . $module["module"] . "\"><div class=\"col-xs-12 usercp_side_item " . $classAtr . "\">" . lang($module["name"], true) . "</div></a>";
                            }
                        }
                    }
                }
                echo "\r\n                </div>\r\n            </div>";
            } else {
                message("error", lang("error_12", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n\r\n<div class=\"container_2 account\" align=\"center\">";
        if (mconfig("active")) {
            if ($accountInfo) {
                $accountLoginInfo = $common->accountLoginInformation($_SESSION["username"]);
                $accountBalance = $common->accountBalance($_SESSION["username"]);
                if ($common->accountOnline($_SESSION["username"])) {
                    $accountOnlineStatus = "<span class=\"online\">" . lang("myaccount_txt_9", true) . "</span>";
                } else {
                    $accountOnlineStatus = "<span class=\"offline\">" . lang("myaccount_txt_10", true) . "</span>";
                }
                if ($accountInfo[_CLMN_BLOCCODE_] == 1) {
                    $accountStatus = "<span class=\"blocked\">" . lang("myaccount_txt_8", true) . "</span>";
                } else {
                    $accountStatus = "<span class=\"active\">" . lang("myaccount_txt_7", true) . "</span>";
                }
                if ($accountLoginInfo["ConnectTM"] == NULL || empty($accountLoginInfo["ConnectTM"])) {
                    $accountLoginInfo["ConnectTM"] = "never";
                }
                if ($accountLoginInfo[_CLMN_MS_IP_] == NULL || empty($accountLoginInfo[_CLMN_MS_IP_])) {
                    $accountLoginInfo[_CLMN_MS_IP_] = "none";
                }
                if ($accountLoginInfo[_CLMN_MS_GS_] == NULL || empty($accountLoginInfo[_CLMN_MS_GS_])) {
                    $accountLoginInfo[_CLMN_MS_GS_] = "none";
                }
                $regDate = date($config["date_format"], strtotime($accountInfo["appl_days"]));
                $loginDate = date($config["time_date_format"], strtotime($accountLoginInfo["ConnectTM"]));
                $Ticket = new Ticket();
                $tickets = $Ticket->getMyTicketsFull($_SESSION["username"]);
                $ticketNotification = "";
                if (is_array($tickets)) {
                    foreach ($tickets as $ticket) {
                        if ($ticket["lastSeen"] < $ticket["updated"]) {
                            $ticketNotification = lang("tickets_txt_25", true);
                        }
                    }
                }
                $BugTracker = new BugTracker();
                $reports = $BugTracker->getMyReportsFull($_SESSION["username"]);
                $trackerNotification = "";
                if (is_array($reports)) {
                    foreach ($reports as $report) {
                        if ($report["lastSeen"] < $report["updated"]) {
                            $trackerNotification = lang("bugtracker_txt_42", true);
                        }
                    }
                }
                echo "\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_light_cont account_info_cont\" align=\"left\">\r\n            <div class=\"account_info\" align=\"left\">\r\n                <ul class=\"account_avatar\">\r\n                    <li id=\"avatar\"><span style=\"background:url(" . __PATH_TEMPLATE__ . "style/images/logo_avatar.png) no-repeat; background-size: 100%;\"></span><p></p></li>\r\n                    <li id=\"server\"><a href=\"" . __BASE_URL__ . "\">" . $config["server_name"] . "</a></li>\r\n                </ul>\r\n                <ul class=\"account_info_main\">\r\n                    <li id=\"accountstat\"><span>" . lang("myaccount_txt_1", true) . "</span><p>" . $accountStatus . "</p></li>\r\n                    <li id=\"username\"><span>" . lang("myaccount_txt_2", true) . "</span><p>" . $accountInfo[_CLMN_USERNM_] . "</p></li>\r\n                    <li><span>" . lang("myaccount_txt_4", true) . "</span><p>********** (<a href=\"" . __BASE_URL__ . "usercp/mypassword/\">" . lang("myaccount_txt_6", true) . "</a>)</p></li>\r\n                    <li><span>" . lang("myaccount_txt_3", true) . "</span><p>" . $accountInfo[_CLMN_EMAIL_] . " (<a href=\"" . __BASE_URL__ . "usercp/myemail/\">" . lang("myaccount_txt_6", true) . "</a>)</p></li>\r\n                    <li style=\"margin:15px 0 0 28px\"></li>";
                if ($config["use_platinum"]) {
                    echo "<li id=\"pcoins\"><span>" . lang("currency_platinum", true) . ":</span><div></div><p>" . number_format($accountBalance["platinum"]) . "</p></li>";
                }
                if ($config["use_gold"]) {
                    echo "<li id=\"gcoins\"><span>" . lang("currency_gold", true) . ":</span><div></div><p>" . number_format($accountBalance["gold"]) . "</p></li>";
                }
                if ($config["use_silver"]) {
                    echo "<li id=\"scoins\"><span>" . lang("currency_silver", true) . ":</span><div></div><p>" . number_format($accountBalance["silver"]) . "</p></li>";
                }
                $currenciesTotal = 0;
                if ($config["use_platinum"]) {
                    $currenciesTotal++;
                }
                if ($config["use_gold"]) {
                    $currenciesTotal++;
                }
                if ($config["use_silver"]) {
                    $currenciesTotal++;
                }
                if ($currenciesTotal < 2) {
                    $cashShop = $dB->query_fetch_single("SELECT * FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
                    if (100 <= config("server_files_season", true)) {
                        if ($config["show_wcoinc"]) {
                            echo "<li><span>" . lang("currency_wcoinc", true) . ":</span><div></div><p>" . number_format($cashShop["WCoin"]) . "</p></li>";
                        }
                    } else {
                        if ($config["show_wcoinc"]) {
                            echo "<li><span>" . lang("currency_wcoinc", true) . ":</span><div></div><p>" . number_format($cashShop["WCoinC"]) . "</p></li>";
                        }
                    }
                    if ($config["show_gp"]) {
                        echo "<li><span>" . lang("currency_gp", true) . ":</span><div></div><p>" . number_format($cashShop["GoblinPoint"]) . "</p></li>";
                    }
                }
                echo "\r\n                </ul>\r\n                <ul class=\"account_info_second\">\r\n                    <li><span>" . lang("myaccount_txt_5", true) . "</span><p>" . $accountOnlineStatus . "</p></li><br>\r\n                    <li><span>" . lang("myaccount_txt_17", true) . "</span><p>" . $loginDate . "</p></li>\r\n                    <li><span>" . lang("myaccount_txt_18", true) . "</span><p>" . $accountLoginInfo[_CLMN_MS_IP_] . "</p></li><br>\r\n                    <li><span>" . lang("myaccount_txt_19", true) . "</span><p>" . $regDate . "</p></li><br>\r\n                    <li><span>" . lang("myaccount_txt_20", true) . "</span><p>" . $accountLoginInfo[_CLMN_MS_GS_] . "</p></li>\r\n                </ul>\r\n                <div class=\"clear\"></div>\r\n            </div>\r\n        </div>";
                if ($ticketNotification != NULL) {
                    echo "\r\n        <div style=\"padding-top: 20px;\">";
                    message("info", $ticketNotification);
                    echo "\r\n        </div>";
                }
                if ($trackerNotification != NULL) {
                    echo "\r\n        <div style=\"padding-top: 20px;\">";
                    message("info", $trackerNotification);
                    echo "\r\n        </div>";
                }
                if ($accountInfo[_CLMN_BLOCCODE_] == 1) {
                    echo "\r\n        <div style=\"padding-top: 20px;\">";
                    message("info", lang("myaccount_txt_82", true));
                    echo "\r\n        </div>";
                }
                $main_menu = mconfig("main_menu");
                $quick_menu = mconfig("quick_menu");
                $userCP = new UserCP();
                $main_menu_sections = $userCP->create_main_manu($main_menu);
                $quick_menu_modules = $userCP->create_quick_menu($quick_menu);
                echo "<ul id=\"accoun_panel_menu\">";
                foreach ($main_menu_sections as $section) {
                    if ($section["active"]) {
                        $name = "";
                        if ($section["name"] == "myaccount_txt_21" || $section["name"] == "myaccount_txt_30" || $section["name"] == "myaccount_txt_55") {
                            $name = lang($section["name"], true);
                        } else {
                            $name = $section["name"];
                        }
                        echo "<li id=\"title\">\r\n                         <a href=\"#\"><div class=\"usercp-title\"><div id=\"title\"><h1>" . $name . "<p></p><span></span></h1></div></div></a>\r\n                      </li>";
                        foreach ($section["modules"] as $module) {
                            if (!$module["hidden"]) {
                                $active = true;
                                $name = "";
                                $desc = "";
                                if ($module["custom"]) {
                                    $name = $module["name"];
                                    $desc = $module["desc"];
                                } else {
                                    loadModuleConfigs($module["config"]);
                                    $active = mconfig("active");
                                    $name = lang($module["name"], true);
                                    $desc = lang($module["desc"], true);
                                }
                                if ($active) {
                                    echo "<li>\r\n                                    <a href=\"" . __BASE_URL__ . $module["module"] . "\">\r\n                                        <div id=\"" . $module["icon"] . "\"></div>\r\n                                        <span><p>" . $name . "</p>" . $desc . "</span>\r\n                                    </a>\r\n                                 </li>";
                                }
                            }
                        }
                    }
                }
                echo "</ul><ul class=\"quick_acc_menu\">";
                $General = new xGeneral();
                loadModuleConfigs("usercp.merchant");
                $merchants = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_MERCHANTS");
                $canAccess = false;
                if (is_array($merchants)) {
                    foreach ($merchants as $thisMerchant) {
                        if ($thisMerchant["AccountID"] == $_SESSION["username"] && $thisMerchant["active"] == "1") {
                            $canAccess = true;
                        }
                    }
                }
                if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("merchant") && mconfig("active") && $canAccess) {
                    echo "<li class=\"special\"><a href=\"" . __BASE_URL__ . "usercp/merchant\">" . lang("myaccount_txt_64", true) . "<p></p><span></span></a></li>";
                }
                foreach ($quick_menu_modules as $module) {
                    if (!$module["hidden"]) {
                        loadModuleConfigs($module["config"]);
                        if (mconfig("active")) {
                            $classAtr = !empty($module["class"]) ? "class=\"" . $module["class"] . "\"" : "";
                            if ($module["module"] == "usercp/claimreward") {
                                $myrewards = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_CLAIM_REWARD WHERE AccountID = ? AND claimed = ? AND (expiration > ? OR expiration IS NULL)", [$_SESSION["username"], 0, date("Y-m-d H:i:s", time())]);
                                if (0 < $myrewards["count"]) {
                                    echo "<li class=\"special\"><a href=\"" . __BASE_URL__ . $module["module"] . "\">" . lang($module["name"], true) . " (" . $myrewards["count"] . ")<p></p><span></span></a></li>";
                                } else {
                                    echo "<li><a href=\"" . __BASE_URL__ . $module["module"] . "\">" . lang($module["name"], true) . "<p></p><span></span></a></li>";
                                }
                            } else {
                                echo "<li " . $classAtr . "><a href=\"" . __BASE_URL__ . $module["module"] . "\">" . lang($module["name"], true) . "<p></p><span></span></a></li>";
                            }
                        }
                    }
                }
                echo "</ul>\r\n              <div class=\"clear\"></div>\r\n            </div>";
            } else {
                message("error", lang("error_12", true));
            }
        } else {
            echo "<div class=\"page-desc-holder\">";
            message("error", lang("error_47", true));
            echo "</div>";
        }
        echo "</div>";
    }
}

?>