<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

define("admincp", true);
try {
    if (!(include_once "../includes/imperiamucms.php")) {
        throw new Exception("Could not load ImperiaMuCMS.");
    }
    if (!isLoggedIn()) {
        redirect(1, "admincp/login.php");
    }
    if (!canAccessAdminCP($_SESSION["username"])) {
        redirect();
    }
    if (!(include_once __PATH_ADMINCP_INC__ . "functions.php")) {
        throw new Exception("Could not load AdminCP functions.");
    }
    if (!(include_once __PATH_ADMINCP_INC__ . "check.php")) {
        throw new Exception("Could not load AdminCP configuration check.");
    }
    $webshopVersion = ["Webshop", ["webshop_old_settings" => "Settings", "webshop_old_logs" => "Logs", "webshop_old_items" => "Items Manager", "webshop_old_packages" => "Packages Manager", "webshop_old_mystery" => "Mystery Box Manager", "webshop_old_sockets" => "Sockets Manager", "webshop_old_harmony" => "Harmony Manager"], "fa-shopping-cart"];
    if ($config["enable_responsive"]) {
        $webshopVersion = ["Webshop", ["webshop_settings" => "Settings", "webshop_logs" => "Logs", "webshop_items" => "Items Manager", "webshop_categories" => "Categories Manager", "webshop_packages" => "Packages Manager", "webshop_mystery" => "Mystery Box Manager", "webshop_sockets" => "Sockets Manager", "webshop_harmony" => "Harmony Manager"], "fa-shopping-cart"];
    }
    $admincpSidebar = [["News Management", ["addnews" => "Publish", "managenews" => "Edit / Delete"], "fa-newspaper-o"], ["Changelogs Management", ["addchangelog" => "Publish", "managechangelog" => "Edit / Delete"], "fa-cog"], ["Bug Tracker", ["bugtracker_reports" => "Reports", "bugtracker_settings" => "Settings"], "fa-bug"], ["Account", ["searchaccount" => "Search", "accountsfromip" => "Find Accounts from IP", "onlineaccounts" => "Online Accounts", "newregistrations" => "New Registrations", "awaitingverification" => "Awaiting Verification", "accountinfo" => ""], "fa-users"], ["Character", ["searchcharacter" => "Search", "editcharacter" => ""], "fa-user"], ["Bans", ["searchban" => "Search", "banaccount" => "Ban Account", "bancharacter" => "Ban Character", "banchat" => "Ban Chat", "banhwid" => "Ban HWID", "latestbans" => "Latest Bans", "blockedips" => "Block IP (web)", "accessrestriction" => "Access Restriction"], "fa-exclamation-circle"], ["Credits", ["creditsconfigs" => "Credit Configurations", "creditsmanager" => "Credit Manager", "latestpaypal" => "PayPal Donations", "latestpaygol" => "PayGol Donations", "latestpw" => "Paymentwall Donations", "latestsr" => "SuperRewards Donations", "latestpaynl" => "Pay.nl Donations", "latesthomepaypl" => "Homepay.pl Donations", "latestpayu" => "PayU.pl Donations", "latestmercadopago" => "MercadoPago Donations", "latestinterkassa" => "Interkassa Donations", "latestnganluong" => "NganLuong Donations", "topvotes" => "Top Voters"], "fa-money"], ["Website Configuration", ["website_config" => "Website Settings", "modules_manager" => "Modules Manager", "template_settings" => "Template Settings", "languages_manager" => "Languages Manager", "admins_manager" => "Admins Manager", "gms_manager" => "Game Masters Manager"], "fa-toggle-on"], ["Scheduled Tasks", ["addcron" => "Add New", "managecron" => "Manage Cron Jobs"], "fa-tasks"], ["Ticket System", ["ticket_settings" => "Settings", "ticket_opened" => "Opened Tickets", "ticket_closed" => "Closed Tickets"], "fa-ticket"], $webshopVersion, ["Cash Shop", ["cashshop_settings" => "Settings", "cashshop_manager" => "Cash Shop Manager", "cashshop_logs" => "Logs"], "fa-cart-plus"], ["Achievements System", ["achievements_settings" => "Achievements Settings", "achievements_manager" => "Achievements Manager", "achievements_logs" => "Achievements Logs"], "fa-trophy"], ["Promotional Codes", ["promo_codes_settings" => "Promo Codes Settings", "promo_manager" => "Codes Manager", "promo_logs" => "Promo Logs"], "fa-gift"], ["Lottery System", ["lottery_settings" => "Lottery Settings", "lottery_logs" => "Lottery Logs", "lottery_reward_logs" => "Lottery Reward Logs"], "fa-money"], ["Auction System", ["auction_settings" => "Auction Settings", "auction_manager" => "Auction Manager", "auction_logs" => "Auction Logs"], "fa-gavel"], ["Guides System", ["guides_settings" => "Guides Settings", "guides_manager" => "Guides Manager"], "fa-info"], ["Logs", ["market_logs" => "Market Logs", "vip_logs" => "VIP Logs", "exchange_logs" => "Exchange Logs", "votes" => "Votes", "vote_logs" => "Vote Logs", "claimreward_logs" => "Claim Reward Logs", "startingkit_logs" => "Starting Kit Logs", "change_class_logs" => "Change Class Logs", "change_name_logs" => "Change Name Logs", "transfer_char_logs" => "Transfer Character Logs", "transfer_coins_logs" => "Transfer Coins Logs", "reset_logs" => "Reset Logs", "greset_logs" => "Grand Reset Logs", "clear_inv_logs" => "Clear Inventory Logs", "gmcp_edit_char_logs" => "GMCP Edit Character Logs"], "fa-archive"]];
    if ($config["enable_logs"]) {
        if (!empty($_POST)) {
            $fp = fopen(__ROOT_DIR__ . "__logs/post_" . date("Y-m-d", time()) . ".log", "ab");
            if ($fp) {
                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] [Username: " . $_SESSION["username"] . "] [" . $_SERVER["REQUEST_URI"] . "] [" . var_export($_POST, true) . "]" . PHP_EOL);
                fclose($fp);
            }
        }
        if (!empty($_GET)) {
            $fp = fopen(__ROOT_DIR__ . "__logs/get_" . date("Y-m-d", time()) . ".log", "ab");
            if ($fp) {
                fwrite($fp, "[" . date($config["time_date_format_logs"], time()) . "] [" . $_SERVER["REMOTE_ADDR"] . "] [Username: " . $_SESSION["username"] . "] [" . $_SERVER["REQUEST_URI"] . "] [" . var_export($_GET, true) . "]" . PHP_EOL);
                fclose($fp);
            }
        }
    }
    $General = new xGeneral();
    if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("badges")) {
        array_push($admincpSidebar, ["Badges", ["badges_settings" => "Settings", "badges_manager" => "Badges Manager", "badges_add_badge" => "Add Badge to Player", "badges_logs" => "Logs"], "fa-bookmark"]);
    } else {
        array_push($admincpSidebar, ["Badges", ["badges_settings" => "Settings", "badges_manager" => "Badges Manager", "badges_logs" => "Logs"], "fa-bookmark"]);
    }
    if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("merchant")) {
        array_push($admincpSidebar, ["Merchant System", ["merchant_settings" => "Settings", "merchant_logs" => "Logs"], "fa-group"]);
    }
    if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("mulords")) {
        array_push($admincpSidebar, ["MU Lords", ["mulords_settings" => "Settings", "mulords_donation" => "Donations"], "fa-group"]);
    }
    if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("networking")) {
        array_push($admincpSidebar, ["Networking", ["networking_settings" => "Settings", "networking_manager" => "Manager"], "fa-group"]);
    }
    if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("transferaccount")) {
        array_push($admincpSidebar, ["Transfer Account", ["transferaccount_settings" => "Settings", "transferaccount_logs" => "Logs"], "fa-exchange"]);
    }
    if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("eventregistration")) {
        array_push($admincpSidebar, ["Event Registration", ["eventregistration_settings" => "Settings", "eventregistration_manager" => "Events Manager", "eventregistration_logs" => "Logs"], "fa-star"]);
    }
    if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("transfercharacterserver")) {
        array_push($admincpSidebar, ["Transfer Character", ["transfercharacterserver_settings" => "Settings", "transfercharacterserver_logs" => "Logs"], "fa-exchange"]);
    }
    checkAdminCPmodules();
    checkGMCPmodules();
    echo "<!DOCTYPE html>\r\n<html lang=\"en\">\r\n<head>\r\n    <meta charset=\"utf-8\">\r\n    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\r\n    <meta name=\"description\" content=\"ImperiaMuCMS AdminCP 1.0\">\r\n    <meta name=\"author\" content=\"jacubb\">\r\n\r\n    <title>ImperiaMuCMS AdminCP</title>\r\n\r\n\r\n    <style>\r\n        .ticket-open {\r\n            -moz-border-radius: 3px;\r\n            -webkit-border-radius: 3px;\r\n            border-radius: 3px;\r\n            padding-left: 5px;\r\n            padding-right: 5px;\r\n            padding-top: 2px;\r\n            padding-bottom: 2px;\r\n            color: #FFFFFF;\r\n            background-color: #007700;\r\n            font-weight: bold;\r\n        }\r\n\r\n        .ticket-closed {\r\n            -moz-border-radius: 3px;\r\n            -webkit-border-radius: 3px;\r\n            border-radius: 3px;\r\n            padding-left: 5px;\r\n            padding-right: 5px;\r\n            padding-top: 2px;\r\n            padding-bottom: 2px;\r\n            color: #FFFFFF;\r\n            background-color: #770000;\r\n            font-weight: bold;\r\n        }\r\n\r\n        .ticket-wait {\r\n            -moz-border-radius: 3px;\r\n            -webkit-border-radius: 3px;\r\n            border-radius: 3px;\r\n            padding-left: 5px;\r\n            padding-right: 5px;\r\n            padding-top: 2px;\r\n            padding-bottom: 2px;\r\n            color: #FFFFFF;\r\n            background-color: #ff9600;\r\n            font-weight: bold;\r\n        }\r\n\r\n        .radio_switch {\r\n            margin: 4px;\r\n            background-color: #EFEFEF;\r\n            border-radius: 4px;\r\n            border: 1px solid #D0D0D0;\r\n            overflow: auto;\r\n        }\r\n\r\n        .radio_switch label {\r\n            float: left;\r\n            width: 50%;\r\n            margin-bottom: 0;\r\n        }\r\n\r\n        .radio_switch label span {\r\n            text-align: center;\r\n            padding: 3px 0px;\r\n            display: block;\r\n            cursor: pointer;\r\n        }\r\n\r\n        .radio_switch label input {\r\n            display: none;\r\n        }\r\n\r\n        .radio_switch input:checked + span {\r\n            background-color: #404040;\r\n            color: #F7F7F7;\r\n        }\r\n\r\n        .radio_switch label.on input:checked + span {\r\n            background: #5cb85c;\r\n            color: #fff;\r\n        }\r\n\r\n        .radio_switch label.off input:checked + span {\r\n            background: #d9534f;\r\n            color: #fff;\r\n        }\r\n\r\n        .radio_switch label.opt1 input:checked + span {\r\n            background: #5bc0de;\r\n            color: #fff;\r\n        }\r\n\r\n        .radio_switch label.opt2 input:checked + span {\r\n            background: #286090;\r\n            color: #fff;\r\n        }\r\n    </style>\r\n\r\n    <!-- Bootstrap Core CSS -->\r\n    <link href=\"css/bootstrap.min.css\" rel=\"stylesheet\">\r\n    <link href=\"css/plugins/metisMenu/metisMenu.min.css\" rel=\"stylesheet\">\r\n    <link href=\"css/sb-admin-2.css\" rel=\"stylesheet\">\r\n    <link href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css\" rel=\"stylesheet\">\r\n    <!--<script src=\"css/plugins/dataTables.bootstrap.css\"></script>-->\r\n    <link href=\"css/imperiamucms.css?v=3\" rel=\"stylesheet\">\r\n    <link href=\"";
    echo __PATH_TEMPLATE__;
    echo "css/colors.css?v=2\" rel=\"stylesheet\">\r\n    <link href=\"css/fileinput.min.css\" rel=\"stylesheet\">\r\n\r\n    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->\r\n    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->\r\n    <!--[if lt IE 9]>\r\n    <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>\r\n    <script src=\"https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js\"></script>\r\n    <![endif]-->\r\n\r\n    <script src=\"js/jquery-1.11.0.js\"></script>\r\n    <script src=\"js/fileinput.min.js\"></script>\r\n    <script src=\"js/bootstrap.min.js\"></script>\r\n    <script src=\"js/plugins/metisMenu/metisMenu.min.js\"></script>\r\n    <script src=\"js/sb-admin-2.js\"></script>\r\n    <!--<script src=\"js/plugins/dataTables/jquery.dataTables.js\"></script>\r\n    <script src=\"js/plugins/dataTables/dataTables.bootstrap.js\"></script>-->\r\n</head>\r\n<body>\r\n<div id=\"wrapper\">\r\n\r\n    <!-- Navigation -->\r\n    <nav class=\"navbar navbar-inverse navbar-static-top\" role=\"navigation\" style=\"margin-bottom: 0\">\r\n        <div class=\"navbar-header\">\r\n            <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">\r\n                <span class=\"sr-only\">Toggle navigation</span>\r\n                <span class=\"icon-bar\"></span>\r\n                <span class=\"icon-bar\"></span>\r\n                <span class=\"icon-bar\"></span>\r\n            </button>\r\n            <a class=\"navbar-brand\" href=\"";
    echo admincp_base();
    echo "\"><img src=\"img/logo.jpg\"/></a>\r\n        </div>\r\n\r\n        <ul class=\"nav navbar-top-links navbar-right\">\r\n            <li><a href=\"";
    echo admincp_base("item_scanner");
    echo "\"><i class=\"fa fa-fw fa-search\"></i> Item Scanner</a></li>\r\n            <li><a href=\"";
    echo admincp_base("special_tools");
    echo "\"><i class=\"fa fa-fw fa-wrench\"></i> Special Tools</a></li>\r\n            <li><a href=\"";
    echo __BASE_URL__;
    echo "\" target=\"_blank\"><i class=\"fa fa-fw fa-home\"></i> Website Home</a></li>\r\n            <li><a href=\"";
    echo __BASE_URL__;
    echo "logout/\"><i class=\"fa fa-fw fa-power-off\"></i> Log Out</a></li>\r\n        </ul>\r\n\r\n        <div class=\"navbar-default sidebar\" role=\"navigation\">\r\n            <div class=\"sidebar-nav navbar-collapse\">\r\n                <ul class=\"nav\" id=\"side-menu\">\r\n                    ";
    foreach ($admincpSidebar as $sidebarItem) {
        if (check_value($_GET["module"]) && array_key_exists($_GET["module"], $sidebarItem[1])) {
            echo "<li class=\"active\">";
        } else {
            echo "<li>";
        }
        $itemIcon = check_value($sidebarItem[2]) ? "<i class=\"fa " . $sidebarItem[2] . " fa-fw\"></i>&nbsp;" : "";
        if (is_array($sidebarItem[1])) {
            $notification = "";
            if ($sidebarItem[0] == "Ticket System") {
                $getOpenTickets = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_TICKETS WHERE status = 0");
                $openTickets = $getOpenTickets["count"];
                if (0 < $openTickets) {
                    $notification = " <span class=\"badge\">" . $openTickets . "</span>";
                }
            } else {
                if ($sidebarItem[0] == "Bug Tracker") {
                    $getOpenTickets = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_BUG_TRACKER WHERE status = 0");
                    $openTickets = $getOpenTickets["count"];
                    if (0 < $openTickets) {
                        $notification = " <span class=\"badge\">" . $openTickets . "</span>";
                    }
                }
            }
            echo "<a href=\"#\">" . $itemIcon . $sidebarItem[0] . $notification . "<span class=\"fa arrow\"></span></a>";
            echo "<ul class=\"nav nav-second-level\">";
            foreach ($sidebarItem[1] as $sidebarSubItemModule => $sidebarSubItemTitle) {
                if (check_value($sidebarSubItemTitle)) {
                    echo "<li><a href=\"" . admincp_base($sidebarSubItemModule) . "\">" . $sidebarSubItemTitle . "</a></li>";
                }
            }
            echo "</ul>";
        } else {
            echo "<a href=\"" . admincp_base($sidebarItem[1]) . "\">" . $itemIcon . $sidebarItem[0] . "</a>";
        }
        echo "</li>";
    }
    if (check_value($extra_admincp_sidebar) && is_array($extra_admincp_sidebar)) {
        echo "<li><a href=\"#\"><i class=\"fa fa-square fa-fw\"></i>Active Plugins<span class=\"fa arrow\"></span></a><ul class=\"nav nav-second-level\">";
        foreach ($extra_admincp_sidebar as $pluginSidebarItem) {
            if (is_array($pluginSidebarItem) && is_array($pluginSidebarItem[1])) {
                echo "<li>";
                echo "<a href=\"#\">" . $pluginSidebarItem[0] . " <span class=\"fa arrow\"></span></a>";
                echo "<ul class=\"nav nav-third-level collapse\" aria-expanded=\"false\" style=\"height: 0px;\">";
                foreach ($pluginSidebarItem[1] as $pluginSidebarSubItem) {
                    echo "<li><a href=\"" . admincp_base($pluginSidebarSubItem[1]) . "\">" . $pluginSidebarSubItem[0] . "</a></li>";
                }
                echo "</ul></li>";
            }
        }
        echo "</ul></li>";
    }
    echo "                </ul>\r\n            </div>\r\n        </div>\r\n    </nav>\r\n\r\n    <!-- Page Content -->\r\n    <div id=\"page-wrapper\">\r\n        <div class=\"row contentpadding\">\r\n            <div class=\"col-lg-12\">\r\n                <!--<h1 class=\"page-header\">Dashboard</h1>-->\r\n                ";
    $handler->loadAdminCPModule($_REQUEST["module"]);
    echo "            </div>\r\n        </div>\r\n    </div>\r\n\r\n</div>\r\n\r\n<script type=\"text/javascript\" language=\"javascript\" class=\"init\">\r\n    \$(document).ready(function () {\r\n        if (\$('#new_registrations').length > 0) {\r\n            \$('#new_registrations').DataTable({\r\n                \"searching\": false,\r\n                \"ordering\": false,\r\n                \"lengthChange\": false,\r\n                \"pageLength\": 10,\r\n                \"info\": false\r\n            });\r\n        }\r\n\r\n        if (\$('#blocked_ips').length > 0) {\r\n            \$('#blocked_ips').DataTable({\r\n                \"searching\": false,\r\n                \"ordering\": false,\r\n                \"lengthChange\": false,\r\n                \"pageLength\": 10,\r\n                \"info\": false\r\n            });\r\n        }\r\n\r\n        if (\$('#paypal_donations').length > 0) {\r\n            \$('#paypal_donations').DataTable({\r\n                \"searching\": true,\r\n                \"ordering\": false,\r\n                \"lengthChange\": false,\r\n                \"pageLength\": 10,\r\n                \"info\": true\r\n            });\r\n        }\r\n\r\n        if (\$('#superrewards_donations').length > 0) {\r\n            \$('#superrewards_donations').DataTable({\r\n                \"searching\": true,\r\n                \"ordering\": false,\r\n                \"lengthChange\": false,\r\n                \"pageLength\": 10,\r\n                \"info\": true\r\n            });\r\n        }\r\n\r\n        if (\$('#credits_logs').length > 0) {\r\n            \$('#credits_logs').DataTable({\r\n                \"searching\": true,\r\n                \"ordering\": false,\r\n                \"lengthChange\": false,\r\n                \"pageLength\": 10,\r\n                \"info\": true\r\n            });\r\n        }\r\n\r\n        if (\$('#webshop_logs').length > 0) {\r\n            \$('#webshop_logs').DataTable({\r\n                \"searching\": false,\r\n                \"ordering\": false,\r\n                \"lengthChange\": false,\r\n                \"pageLength\": 50,\r\n                \"info\": false\r\n            });\r\n        }\r\n\r\n        if (\$('#item_scanner').length > 0) {\r\n            \$('#item_scanner').DataTable({\r\n                \"searching\": true,\r\n                \"ordering\": true,\r\n                \"lengthChange\": false,\r\n                \"pageLength\": 50,\r\n                \"info\": true\r\n            });\r\n        }\r\n    });\r\n</script>\r\n</body>\r\n</html>\r\n\r\n";
} catch (Exception $ex) {
    $errorPage = @file_get_contents("../includes/error.html");
    echo @str_replace("{ERROR_MESSAGE}", @$ex->getMessage(), $errorPage);
    exit;
}

?>