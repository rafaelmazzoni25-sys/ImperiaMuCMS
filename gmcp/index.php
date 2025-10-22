<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "\r\n    <style>\r\n        .ticket-open {\r\n            -moz-border-radius: 3px;\r\n            -webkit-border-radius: 3px;\r\n            border-radius: 3px;\r\n            padding-left: 5px;\r\n            padding-right: 5px;\r\n            padding-top: 2px;\r\n            padding-bottom: 2px;\r\n            color: #FFFFFF;\r\n            background-color: #007700;\r\n            font-weight: bold;\r\n        }\r\n\r\n        .ticket-closed {\r\n            -moz-border-radius: 3px;\r\n            -webkit-border-radius: 3px;\r\n            border-radius: 3px;\r\n            padding-left: 5px;\r\n            padding-right: 5px;\r\n            padding-top: 2px;\r\n            padding-bottom: 2px;\r\n            color: #FFFFFF;\r\n            background-color: #770000;\r\n            font-weight: bold;\r\n        }\r\n\r\n        .ticket-wait {\r\n            -moz-border-radius: 3px;\r\n            -webkit-border-radius: 3px;\r\n            border-radius: 3px;\r\n            padding-left: 5px;\r\n            padding-right: 5px;\r\n            padding-top: 2px;\r\n            padding-bottom: 2px;\r\n            color: #FFFFFF;\r\n            background-color: #ff9600;\r\n            font-weight: bold;\r\n        }\r\n\r\n        .radio_switch {\r\n            margin: 4px;\r\n            background-color: #EFEFEF;\r\n            border-radius: 4px;\r\n            border: 1px solid #D0D0D0;\r\n            overflow: auto;\r\n        }\r\n\r\n        .radio_switch label {\r\n            float: left;\r\n            width: 50%;\r\n            margin-bottom: 0;\r\n        }\r\n\r\n        .radio_switch label span {\r\n            text-align: center;\r\n            padding: 3px 0px;\r\n            display: block;\r\n            cursor: pointer;\r\n        }\r\n\r\n        .radio_switch label input {\r\n            display: none;\r\n        }\r\n\r\n        .radio_switch input:checked + span {\r\n            background-color: #404040;\r\n            color: #F7F7F7;\r\n        }\r\n\r\n        .radio_switch label.on input:checked + span {\r\n            background: #5cb85c;\r\n            color: #fff;\r\n        }\r\n\r\n        .radio_switch label.off input:checked + span {\r\n            background: #d9534f;\r\n            color: #fff;\r\n        }\r\n\r\n        .radio_switch label.opt1 input:checked + span {\r\n            background: #5bc0de;\r\n            color: #fff;\r\n        }\r\n\r\n        .radio_switch label.opt2 input:checked + span {\r\n            background: #286090;\r\n            color: #fff;\r\n        }\r\n    </style>\r\n\r\n";
define("gmcp", true);
try {
    if (!(include_once "../includes/imperiamucms.php")) {
        throw new Exception("Could not load ImperiaMuCMS.");
    }
    loadModuleConfigs("gmcp");
    if (mconfig("active")) {
        try {
            if (!(include_once "../includes/imperiamucms.php")) {
                throw new Exception("Could not load ImperiaMuCMS.");
            }
            if (!isLoggedIn()) {
                redirect();
            }
            if (!canAccessGMCP($_SESSION["username"])) {
                redirect();
            }
            if (!(include_once __PATH_GMCP_INC__ . "functions.php")) {
                throw new Exception("Could not load GMCP functions.");
            }
            if (!(include_once __PATH_GMCP_INC__ . "check.php")) {
                throw new Exception("Could not load GMCP configuration check.");
            }
            include_once "menu.php";
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
            echo "    <!DOCTYPE html>\r\n    <html lang=\"en\">\r\n    <head>\r\n        <meta charset=\"utf-8\">\r\n        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\r\n        <meta name=\"description\" content=\"ImperiaMuCMS GMCP 1.0\">\r\n        <meta name=\"author\" content=\"jacubb\">\r\n\r\n        <title>ImperiaMuCMS GMCP</title>\r\n\r\n        <!-- Bootstrap Core CSS -->\r\n        <link href=\"css/bootstrap.min.css\" rel=\"stylesheet\">\r\n        <link href=\"css/plugins/metisMenu/metisMenu.min.css\" rel=\"stylesheet\">\r\n        <link href=\"css/sb-admin-2.css\" rel=\"stylesheet\">\r\n        <link href=\"http://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css\" rel=\"stylesheet\">\r\n        <script src=\"css/plugins/dataTables.bootstrap.css\"></script>\r\n        <link href=\"css/imperiamucms.css\" rel=\"stylesheet\">\r\n\r\n        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->\r\n        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->\r\n        <!--[if lt IE 9]>\r\n        <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>\r\n        <script src=\"https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js\"></script>\r\n        <![endif]-->\r\n\r\n    </head>\r\n    <body>\r\n    <div id=\"wrapper\">\r\n\r\n        <!-- Navigation -->\r\n        <nav class=\"navbar navbar-inverse navbar-static-top\" role=\"navigation\" style=\"margin-bottom: 0\">\r\n            <div class=\"navbar-header\">\r\n                <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">\r\n                    <span class=\"sr-only\">Toggle navigation</span>\r\n                    <span class=\"icon-bar\"></span>\r\n                    <span class=\"icon-bar\"></span>\r\n                    <span class=\"icon-bar\"></span>\r\n                </button>\r\n                <a class=\"navbar-brand\" href=\"";
            echo gmcp_base();
            echo "\"><img src=\"img/logo.jpg\"/></a>\r\n            </div>\r\n\r\n            <ul class=\"nav navbar-top-links navbar-right\">\r\n                <li><a href=\"";
            echo __BASE_URL__;
            echo "\" target=\"_blank\"><i class=\"fa fa-fw fa-home\"></i> Website Home</a>\r\n                </li>\r\n                <li><a href=\"";
            echo __BASE_URL__;
            echo "logout/\"><i class=\"fa fa-fw fa-power-off\"></i> Log Out</a></li>\r\n            </ul>\r\n\r\n            <div class=\"navbar-default sidebar\" role=\"navigation\">\r\n                <div class=\"sidebar-nav navbar-collapse\">\r\n                    <ul class=\"nav\" id=\"side-menu\">\r\n                        ";
            foreach ($gmcpSidebar as $sidebarItem) {
                if (check_value($_GET["module"]) && array_key_exists($_GET["module"], $sidebarItem[1])) {
                    echo "<li class=\"active\">";
                } else {
                    echo "<li>";
                }
                $itemIcon = check_value($sidebarItem[2]) ? "<i class=\"fa " . $sidebarItem[2] . " fa-fw\"></i>&nbsp;" : "";
                if (is_array($sidebarItem[1])) {
                    $notification = "";
                    if ($sidebarItem[0] == "Ticket System") {
                        $getOpenTickets = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_TICKETS WHERE status = 0 OR status = 2");
                        $openTickets = $getOpenTickets["count"];
                        if (0 < $openTickets) {
                            $notification = " <span class=\"badge\">" . $openTickets . "</span>";
                        }
                    }
                    echo "<a href=\"#\">" . $itemIcon . $sidebarItem[0] . $notification . "<span class=\"fa arrow\"></span></a>";
                    echo "<ul class=\"nav nav-second-level\">";
                    foreach ($sidebarItem[1] as $sidebarSubItemModule => $sidebarSubItemTitle) {
                        if (check_value($sidebarSubItemTitle)) {
                            echo "<li><a href=\"" . gmcp_base($sidebarSubItemModule) . "\">" . $sidebarSubItemTitle . "</a></li>";
                        }
                    }
                    echo "</ul>";
                } else {
                    echo "<a href=\"" . gmcp_base($sidebarItem[1]) . "\">" . $itemIcon . $sidebarItem[0] . "</a>";
                }
                echo "</li>";
            }
            echo "                    </ul>\r\n                </div>\r\n            </div>\r\n        </nav>\r\n\r\n        <!-- Page Content -->\r\n        <div id=\"page-wrapper\">\r\n            <div class=\"row contentpadding\">\r\n                <div class=\"col-lg-12\">\r\n                    <!--<h1 class=\"page-header\">Dashboard</h1>-->\r\n                    ";
            $handler->loadGMCPModule($_REQUEST["module"]);
            echo "                </div>\r\n            </div>\r\n        </div>\r\n\r\n    </div>\r\n    <script src=\"js/jquery-1.11.0.js\"></script>\r\n    <script src=\"js/bootstrap.min.js\"></script>\r\n    <script src=\"js/plugins/metisMenu/metisMenu.min.js\"></script>\r\n    <script src=\"js/sb-admin-2.js\"></script>\r\n    <script src=\"js/plugins/dataTables/jquery.dataTables.js\"></script>\r\n    <script src=\"js/plugins/dataTables/dataTables.bootstrap.js\"></script>\r\n    <script type=\"text/javascript\" language=\"javascript\" class=\"init\">\r\n        \$(document).ready(function () {\r\n            \$('#new_registrations').DataTable({\r\n                \"searching\": false,\r\n                \"ordering\": false,\r\n                \"lengthChange\": false,\r\n                \"pageLength\": 10,\r\n                \"info\": false\r\n            });\r\n            \$('#blocked_ips').DataTable({\r\n                \"searching\": false,\r\n                \"ordering\": false,\r\n                \"lengthChange\": false,\r\n                \"pageLength\": 10,\r\n                \"info\": false\r\n            });\r\n            \$('#paypal_donations').DataTable({\r\n                \"searching\": true,\r\n                \"ordering\": false,\r\n                \"lengthChange\": false,\r\n                \"pageLength\": 10,\r\n                \"info\": true\r\n            });\r\n            \$('#superrewards_donations').DataTable({\r\n                \"searching\": true,\r\n                \"ordering\": false,\r\n                \"lengthChange\": false,\r\n                \"pageLength\": 10,\r\n                \"info\": true\r\n            });\r\n            \$('#credits_logs').DataTable({\r\n                \"searching\": true,\r\n                \"ordering\": false,\r\n                \"lengthChange\": false,\r\n                \"pageLength\": 10,\r\n                \"info\": true\r\n            });\r\n            \$('#webshop_logs').DataTable({\r\n                \"searching\": false,\r\n                \"ordering\": false,\r\n                \"lengthChange\": false,\r\n                \"pageLength\": 50,\r\n                \"info\": false\r\n            });\r\n        });\r\n    </script>\r\n    </body>\r\n    </html>\r\n\r\n    ";
        } catch (Exception $ex) {
            $errorPage = @file_get_contents("../includes/error.html");
            echo @str_replace("{ERROR_MESSAGE}", @$ex->getMessage(), $errorPage);
            exit;
        }
    }
} catch (Exception $ex) {
    $errorPage = @file_get_contents("../includes/error.html");
    echo @str_replace("{ERROR_MESSAGE}", @$ex->getMessage(), $errorPage);
    exit;
}

?>