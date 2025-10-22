<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

function admincp_base($module = "")
{
    if (check_value($module)) {
        return __PATH_ADMINCP_HOME__ . "?module=" . $module;
    }
    return __PATH_ADMINCP_HOME__;
}
function enabledisableCheckboxes($name, $checked, $e_txt, $d_txt)
{
    echo "<div class=\"radio_switch\">";
    if ($checked == 1) {
        echo "<label class=\"on\"><input type=\"radio\" name=\"" . $name . "\" value=\"1\" checked><span>" . $e_txt . "</span></label>";
    } else {
        echo "<label class=\"on\"><input type=\"radio\" name=\"" . $name . "\" value=\"1\"><span>" . $e_txt . "</span></label>";
    }
    if ($checked == 0) {
        echo "<label class=\"off\"><input type=\"radio\" name=\"" . $name . "\" value=\"0\" checked><span>" . $d_txt . "</span></label>";
    } else {
        echo "<label class=\"off\"><input type=\"radio\" name=\"" . $name . "\" value=\"0\"><span>" . $d_txt . "</span></label>";
    }
    echo "</div>";
}
function enabledisableCheckboxes2($name, $checked, $e_txt, $d_txt)
{
    echo "<div class=\"radio_switch\">";
    if ($checked == 1) {
        echo "<label class=\"opt1\"><input type=\"radio\" name=\"" . $name . "\" value=\"1\" checked><span>" . $e_txt . "</span></label>";
    } else {
        echo "<label class=\"opt1\"><input type=\"radio\" name=\"" . $name . "\" value=\"1\"><span>" . $e_txt . "</span></label>";
    }
    if ($checked == 0) {
        echo "<label class=\"opt2\"><input type=\"radio\" name=\"" . $name . "\" value=\"0\" checked><span>" . $d_txt . "</span></label>";
    } else {
        echo "<label class=\"opt2\"><input type=\"radio\" name=\"" . $name . "\" value=\"0\"><span>" . $d_txt . "</span></label>";
    }
    echo "</div>";
}
function tableExists($table_name, $db)
{
    $tableExists = $db->query_fetch_single("SELECT * FROM sysobjects WHERE xtype = 'U' AND name = ?", [$table_name]);
    if (!$tableExists) {
        return false;
    }
    return true;
}
function checkVersion()
{
    $url = __IMPERIAMUCMS_LICENSE_SERVER__ . "version.php";
    $latestVersion = curl_file_get_contents($url);
    $currentVersionTMP = explode(".", __IMPERIAMUCMS_VERSION__);
    $latestVersionTMP = explode(".", $latestVersion);
    if (count($currentVersionTMP) == 3) {
        if (strlen($currentVersionTMP[1]) < 2) {
            $currentVersionTMP[1] = "0" . $currentVersionTMP[1];
        }
        if (strlen($currentVersionTMP[2]) < 2) {
            $currentVersionTMP[2] = "0" . $currentVersionTMP[2];
        }
        $currentVersion = $currentVersionTMP[0] . $currentVersionTMP[1] . $currentVersionTMP[2] . "00";
    } else {
        if (count($currentVersionTMP) == 4) {
            if (strlen($currentVersionTMP[1]) < 2) {
                $currentVersionTMP[1] = "0" . $currentVersionTMP[1];
            }
            if (strlen($currentVersionTMP[2]) < 2) {
                $currentVersionTMP[2] = "0" . $currentVersionTMP[2];
            }
            if (strlen($currentVersionTMP[3]) < 2) {
                $currentVersionTMP[3] = "0" . $currentVersionTMP[3];
            }
            $currentVersion = $currentVersionTMP[0] . $currentVersionTMP[1] . $currentVersionTMP[2] . $currentVersionTMP[3];
        }
    }
    if (count($latestVersionTMP) == 3) {
        if (strlen($latestVersionTMP[1]) < 2) {
            $latestVersionTMP[1] = "0" . $latestVersionTMP[1];
        }
        if (strlen($latestVersionTMP[2]) < 2) {
            $latestVersionTMP[2] = "0" . $latestVersionTMP[2];
        }
        $latestVersion = $latestVersionTMP[0] . $latestVersionTMP[1] . $latestVersionTMP[2] . "00";
    } else {
        if (count($latestVersionTMP) == 4) {
            if (strlen($latestVersionTMP[1]) < 2) {
                $latestVersionTMP[1] = "0" . $latestVersionTMP[1];
            }
            if (strlen($latestVersionTMP[2]) < 2) {
                $latestVersionTMP[2] = "0" . $latestVersionTMP[2];
            }
            if (strlen($latestVersionTMP[3]) < 2) {
                $latestVersionTMP[3] = "0" . $latestVersionTMP[3];
            }
            $latestVersion = $latestVersionTMP[0] . $latestVersionTMP[1] . $latestVersionTMP[2] . $latestVersionTMP[3];
        }
    }
    if ($currentVersion < $latestVersion) {
        return true;
    }
    return false;
}
function latestVersion()
{
    $url = __IMPERIAMUCMS_LICENSE_SERVER__ . "version.php";
    $latestVersion = curl_file_get_contents($url);
    return $latestVersion;
}
function checkAdminCPmodules()
{
    global $config;
    if (is_writable(__PATH_INCLUDES__ . "config.php")) {
        $configSize = count($config["admincp_modules_access"]);
        $modulesSize = 0;
        foreach (glob(__PATH_ADMINCP__ . "modules/*.php") as $file) {
            $modulesSize++;
        }
        if ($configSize < $modulesSize) {
            $admincpModules = [];
            foreach ($config["admincp_modules_access"] as $module => $access) {
                array_push($admincpModules, $module);
            }
            $configFile = file_get_contents(__PATH_INCLUDES__ . "config.php");
            $configStart = strstr($configFile, "\$config[\"admincp_modules_access\"] = array(", true);
            $configPos = strstr($configFile, "\$config[\"admincp_modules_access\"] = array(");
            $configMid = strstr($configPos, ");", true);
            $configEnd = strstr($configPos, ");");
            $i = 0;
            $newConfig = "\$config[\"admincp_modules_access\"] = array(";
            foreach (glob(__PATH_ADMINCP__ . "modules/*.php") as $file) {
                $fileName = basename($file);
                if (!in_array($fileName, $admincpModules)) {
                    $newConfig .= "\r\n    \"" . $fileName . "\" => 100,";
                } else {
                    $newConfig .= "\r\n    \"" . $fileName . "\" => " . $config["admincp_modules_access"][$fileName] . ",";
                }
            }
            $newConfig .= "\r\n";
            $fileContent = $configStart . $newConfig . $configEnd;
            file_put_contents(__PATH_INCLUDES__ . "config.php", $fileContent);
        }
    } else {
        message("error", __PATH_INCLUDES__ . "config.php is not writable!");
    }
}
function checkGMCPmodules()
{
    global $config;
    if (is_writable(__PATH_INCLUDES__ . "config.php")) {
        $configSize = count($config["gmcp_modules_access"]);
        $modulesSize = 0;
        foreach (glob(__PATH_GMCP__ . "modules/*.php") as $file) {
            $modulesSize++;
        }
        if ($configSize < $modulesSize) {
            $gmcpModules = [];
            foreach ($config["gmcp_modules_access"] as $module => $access) {
                array_push($gmcpModules, $module);
            }
            $configFile = file_get_contents(__PATH_INCLUDES__ . "config.php");
            $configStart = strstr($configFile, "\$config[\"gmcp_modules_access\"] = array(", true);
            $configPos = strstr($configFile, "\$config[\"gmcp_modules_access\"] = array(");
            $configMid = strstr($configPos, ");", true);
            $configEnd = strstr($configPos, ");");
            $i = 0;
            $newConfig = "\$config[\"gmcp_modules_access\"] = array(";
            foreach (glob(__PATH_GMCP__ . "modules/*.php") as $file) {
                $fileName = basename($file);
                if (!in_array($fileName, $gmcpModules)) {
                    $newConfig .= "\r\n    \"" . $fileName . "\" => 100,";
                } else {
                    $newConfig .= "\r\n    \"" . $fileName . "\" => " . $config["gmcp_modules_access"][$fileName] . ",";
                }
            }
            $newConfig .= "\r\n";
            $fileContent = $configStart . $newConfig . $configEnd;
            file_put_contents(__PATH_INCLUDES__ . "config.php", $fileContent);
        }
    } else {
        message("error", __PATH_INCLUDES__ . "config.php is not writable!");
    }
}
function generateLogPage($pageName, $itemTooltip, $page, $limit, $search, $dateStart = NULL, $dateEnd = NULL)
{
    global $dB;
    global $config;
    global $custom;
    global $common;
    $Market = new Market();
    $Items = new Items();
    $Promo = new Promo();
    $Exchange = new Exchange();
    $Currency = new Currency();
    echo "<link href=\"" . __BASE_URL__ . "admincp/css/bootstrap-datetimepicker.min.css\" rel=\"stylesheet\">";
    echo "<script type=\"text/javascript\" src=\"js/moment.js\"></script><script type=\"text/javascript\" src=\"js/bootstrap-datetimepicker.min.js\"></script>";
    if ($itemTooltip) {
        define("__RESPONSIVE__", "FALSE");
        echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
    }
    $logPageData = logPages();
    $columns = "";
    foreach ($logPageData[$pageName]["columns"] as $thisColumn) {
        if ($thisColumn["name2"] != NULL) {
            if ($columns != "") {
                $columns .= ",";
            }
            $columns .= $thisColumn["name2"];
        } else {
            if ($thisColumn["name"] != "") {
                if ($columns != "") {
                    $columns .= ",";
                }
                $columns .= $thisColumn["name"];
            }
        }
    }
    $logsCondition = "";
    $columns2 = "";
    if ($search != NULL) {
        foreach ($logPageData[$pageName]["columns"] as $thisColumn) {
            if ($thisColumn["type"] != "date" && $thisColumn["type"] != "items" && $thisColumn["type"] != "amount_type" && $thisColumn["type"] != "amount_type_e" && $thisColumn["type"] != "amount_type_c" && $thisColumn["name"] != NULL && $thisColumn["name"] != "") {
                if ($columns2 != "") {
                    $columns2 .= " OR ";
                }
                $columns2 .= $thisColumn["name"] . " LIKE '%" . addslashes($search) . "%'";
            }
        }
    }
    if ($dateStart != NULL) {
        if ($columns2 != "") {
            $columns2 = "(" . $columns2 . ") AND ";
        }
        if ($logPageData[$pageName]["columns"][0]["type"] == "date") {
            $columns2 .= $logPageData[$pageName]["columns"][0]["name"] . " >= '" . $dateStart . "'";
        } else {
            if ($logPageData[$pageName]["columns"][0]["type"] == "timestamp") {
                $columns2 .= $logPageData[$pageName]["columns"][0]["name"] . " >= '" . strtotime($dateStart) . "'";
            }
        }
    }
    if ($dateEnd != NULL) {
        if ($columns2 != "") {
            $columns2 = "(" . $columns2 . ") AND ";
        }
        if ($logPageData[$pageName]["columns"][0]["type"] == "date") {
            $columns2 .= $logPageData[$pageName]["columns"][0]["name"] . " <= '" . $dateEnd . "'";
        } else {
            if ($logPageData[$pageName]["columns"][0]["type"] == "timestamp") {
                $columns2 .= $logPageData[$pageName]["columns"][0]["name"] . " <= '" . strtotime($dateEnd) . "'";
            }
        }
    }
    if ($logPageData[$pageName]["where"] != NULL) {
        if ($columns2 != "") {
            $columns2 = "(" . $columns2 . ") AND ";
        }
        $columns2 .= $logPageData[$pageName]["where"];
    }
    if ($columns2 != "") {
        $logsCondition = "WHERE " . $columns2;
    }
    $logsQuery = "\r\n        SELECT " . $columns . " \r\n        FROM " . $logPageData[$pageName]["table"] . "\r\n        " . $logsCondition . "\r\n        ORDER BY " . $logPageData[$pageName]["order"] . "\r\n        OFFSET " . intval($page * $limit - $limit) . " ROWS FETCH NEXT " . intval($limit) . " ROWS ONLY";
    $logs = $dB->query_fetch($logsQuery);
    $logsTotal = $dB->query_fetch_single("\r\n        SELECT COUNT (" . $logPageData[$pageName]["columns"][0]["name"] . ") as total\r\n        FROM " . $logPageData[$pageName]["table"] . "\r\n        " . $logsCondition . "");
    $exportData = [];
    $exportQuery = "\r\n    SELECT " . $columns . " \r\n    FROM " . $logPageData[$pageName]["table"] . "\r\n    " . $logsCondition . "\r\n    ORDER BY " . $logPageData[$pageName]["order"] . "";
    $exportData["query"] = $exportQuery;
    $exportData["name"] = $pageName;
    echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-3\">\r\n            <a href=\"" . __BASE_URL__ . "admincp/export_data.php?data=" . base64_encode(json_encode($exportData)) . "\"><button class=\"btn btn-default\">Export Data</button></a>\r\n        </div>\r\n        <div class=\"col-xs-12 col-md-9\">\r\n            <form method=\"get\" class=\"form-inline text-right\">\r\n                <input type=\"hidden\" name=\"module\" value=\"" . $pageName . "\" />\r\n                <input type=\"hidden\" name=\"pg\" value=\"" . $page . "\" />\r\n                <div class=\"form-group\">\r\n                    <label>Date Range: </label>\r\n                    <div class=\"input-group\">\r\n                        <div class=\"input-group date\" id=\"startdate\">\r\n                            <input id=\"start\" type=\"text\" class=\"form-control\" name=\"start\" value=\"" . $dateStart . "\" placeholder=\"Start Date\" />\r\n                            <span class=\"input-group-addon\">\r\n                                <span class=\"glyphicon glyphicon-calendar\"></span>\r\n                            </span>\r\n                        </div>&nbsp;\r\n                        <div class=\"input-group date\" id=\"enddate\">\r\n                            <input id=\"end\" type=\"text\" class=\"form-control\" name=\"end\" value=\"" . $dateEnd . "\" placeholder=\"End Date\" />\r\n                            <span class=\"input-group-addon\">\r\n                                <span class=\"glyphicon glyphicon-calendar\"></span>\r\n                            </span>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <label>Keyword: </label>\r\n                    <input id=\"keyword\" type=\"text\" name=\"search\" value=\"" . $search . "\" placeholder=\"Keyword\" class=\"form-control\" style=\"width: 200px;\" />\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <input id=\"filter-submit\" type=\"submit\" value=\"Search\" class=\"btn btn-primary\" />\r\n                    <button class=\"btn btn-danger\" onclick=\"clearFilter(); return false;\">Clear</button>\r\n                </div>\r\n                <script type=\"text/javascript\">\r\n                    \$(function () {\r\n                        \$('#startdate').datetimepicker({\r\n                            format: 'YYYY-MM-DD'\r\n                        });\r\n                        \$('#enddate').datetimepicker({\r\n                            format: 'YYYY-MM-DD'\r\n                        });\r\n                    });\r\n                    \r\n                    function clearFilter() {\r\n                        \$('#start').val('');\r\n                        \$('#end').val('');\r\n                        \$('#keyword').val('');\r\n                        \$('#filter-submit').click();\r\n                    }\r\n                </script>\r\n            </form>\r\n        </div>\r\n    </div>\r\n    <br />";
    if (is_array($logs)) {
        echo "\r\n        <table class=\"table table-hover display\">\r\n            <thead>\r\n                <tr>";
        foreach ($logPageData[$pageName]["columns"] as $thisColumn) {
            if ($thisColumn["type"] != "amount_type" && $thisColumn["type"] != "amount_type_e" && $thisColumn["type"] != "amount_type_c") {
                echo "<th>" . $thisColumn["title"] . "</th>";
            }
        }
        echo "\r\n                </tr>\r\n            </thead>\r\n            <tbody>";
        foreach ($logs as $thisRow) {
            echo "<tr>";
            $i = 0;
            while ($i < count($logPageData[$pageName]["columns"])) {
                echo "<td>";
                if ($logPageData[$pageName]["columns"][$i]["type"] == "date") {
                    echo date($config["time_date_format_logs"], strtotime($thisRow[$logPageData[$pageName]["columns"][$i]["name"]]));
                } else {
                    if ($logPageData[$pageName]["columns"][$i]["type"] == "timestamp") {
                        echo date($config["time_date_format_logs"], $thisRow[$logPageData[$pageName]["columns"][$i]["name"]]);
                    } else {
                        if ($logPageData[$pageName]["columns"][$i]["type"] == "text") {
                            echo $thisRow[$logPageData[$pageName]["columns"][$i]["name"]];
                        } else {
                            if ($logPageData[$pageName]["columns"][$i]["type"] == "userid") {
                                $userData = $common->accountInformation($thisRow[$logPageData[$pageName]["columns"][$i]["name"]]);
                                echo $userData[_CLMN_USERNM_];
                            } else {
                                if ($logPageData[$pageName]["columns"][$i]["type"] == "items") {
                                    $rewardItems = explode(",", $thisRow[$logPageData[$pageName]["columns"][$i]["name"]]);
                                    $rewardItemsShow = "";
                                    $j = 0;
                                    foreach ($rewardItems as $thisItem) {
                                        $itemData = explode(":", $thisItem);
                                        list($itemHex, $itemExp) = $itemData;
                                        $itemInfo = $Items->ItemInfo($itemHex);
                                        $rewardItemsShow .= "<span  style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 0, 1, 1, 1, $itemExp) . ")\" onmouseout=\"UnTip()\">" . $itemInfo["name"] . "</span>";
                                        if ($j != count($rewardItems) - 1) {
                                            $rewardItemsShow .= ", ";
                                        }
                                        $j++;
                                    }
                                    echo $rewardItemsShow;
                                } else {
                                    if ($logPageData[$pageName]["columns"][$i]["type"] == "amount") {
                                        if (0 < $thisRow[$logPageData[$pageName]["columns"][$i]["name"]]) {
                                            echo number_format($thisRow[$logPageData[$pageName]["columns"][$i]["name"]]) . " " . $Promo->getCurrencyName($thisRow[$logPageData[$pageName]["columns"][$i + 1]["name"]]);
                                        }
                                        $i++;
                                    } else {
                                        if ($logPageData[$pageName]["columns"][$i]["type"] == "amount_e") {
                                            if (0 < $thisRow[$logPageData[$pageName]["columns"][$i]["name"]]) {
                                                echo number_format($thisRow[$logPageData[$pageName]["columns"][$i]["name"]]) . " " . $Exchange->getCurrencyName($thisRow[$logPageData[$pageName]["columns"][$i + 1]["name"]]);
                                            }
                                            $i++;
                                        } else {
                                            if ($logPageData[$pageName]["columns"][$i]["type"] == "amount_c") {
                                                if (0 < $thisRow[$logPageData[$pageName]["columns"][$i]["name"]]) {
                                                    echo number_format($thisRow[$logPageData[$pageName]["columns"][$i]["name"]]) . " " . $Currency->getCurrencyData($thisRow[$logPageData[$pageName]["columns"][$i + 1]["name"]])["name"];
                                                }
                                                $i++;
                                            } else {
                                                if ($logPageData[$pageName]["columns"][$i]["type"] == "amount_money") {
                                                    if (0 < $thisRow[$logPageData[$pageName]["columns"][$i]["name"]]) {
                                                        echo number_format($thisRow[$logPageData[$pageName]["columns"][$i]["name"]]) . " " . $thisRow[$logPageData[$pageName]["columns"][$i + 1]["name"]];
                                                    }
                                                    $i++;
                                                } else {
                                                    if ($logPageData[$pageName]["columns"][$i]["type"] == "class") {
                                                        echo $custom["character_class"][$thisRow[$logPageData[$pageName]["columns"][$i]["name"]]][0];
                                                    } else {
                                                        if ($logPageData[$pageName]["columns"][$i]["type"] == "input-text") {
                                                            echo "<input type=\"text\" class=\"form-control\" style=\"width: " . $logPageData[$pageName]["columns"][$i]["input-width"] . ";\" value=\"" . $thisRow[$logPageData[$pageName]["columns"][$i]["name"]] . "\" />";
                                                        } else {
                                                            if ($logPageData[$pageName]["columns"][$i]["type"] == "status") {
                                                                if ($thisRow[$logPageData[$pageName]["columns"][$i]["name"]] == "0") {
                                                                    echo "<span class=\"label label-default\">Reversed</span>";
                                                                } else {
                                                                    if ($thisRow[$logPageData[$pageName]["columns"][$i]["name"]] == "1") {
                                                                        echo "<span class=\"label label-success\">OK</span>";
                                                                    }
                                                                }
                                                            } else {
                                                                if ($logPageData[$pageName]["columns"][$i]["type"] == "transaction") {
                                                                    if ($thisRow[$logPageData[$pageName]["columns"][$i]["name"]] == "add") {
                                                                        echo "<span class=\"label label-success\">Add</span>";
                                                                    } else {
                                                                        echo "<span class=\"label label-danger\">Subtract</span>";
                                                                    }
                                                                } else {
                                                                    if ($logPageData[$pageName]["columns"][$i]["type"] == "yes/no") {
                                                                        if ($thisRow[$logPageData[$pageName]["columns"][$i]["name"]] == "1") {
                                                                            echo "<span class=\"label label-success\">Yes</span>";
                                                                        } else {
                                                                            echo "<span class=\"label label-default\">No</span>";
                                                                        }
                                                                    } else {
                                                                        if ($logPageData[$pageName]["columns"][$i]["type"] == "acc-info") {
                                                                            echo "<a href=\"" . admincp_base("accountinfo&id=" . $thisRow[$logPageData[$pageName]["columns"][1]["name"]]) . "\" class=\"btn btn-xs btn-default\">Account Information</a>";
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
                echo "</td>";
                $i++;
            }
            echo "</tr>";
        }
        echo "\r\n            </tbody>\r\n        </table>\r\n        <div class=\"row\">\r\n            <nav aria-label=\"pagination\" class=\"col-xs-12 text-center\">\r\n                <ul class=\"pagination\">";
        $total_pages = ceil($logsTotal["total"] / $limit);
        $pageUrl = admincp_base($pageName) . "&pg=%pageHolder%";
        if ($search != NULL && $search != "") {
            $pageUrl .= "&search=" . $pageUrl;
        }
        generatePagination($total_pages, $page, $pageUrl);
        echo "\r\n                </ul>\r\n            </nav>\r\n        </div>";
    } else {
        message("notice", "No logs found in database.");
    }
}
function export_data_to_csv($data, $filename = "export", $delimiter = ";", $enclosure = "\"")
{
    header("Content-disposition: attachment; filename=" . $filename . ".csv");
    header("Content-Type: text/csv");
    $fp = fopen("php://output", "w");
    fputs($fp, $bom = chr(239) . chr(187) . chr(191));
    fputcsv($fp, array_keys($data[0]), $delimiter, $enclosure);
    foreach ($data as $fields) {
        fputcsv($fp, $fields, $delimiter, $enclosure);
    }
    fclose($fp);
    exit;
}
function logPages()
{
    $pages = ["claimreward_logs" => ["table" => "IMPERIAMUCMS_CLAIM_REWARD_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "Name", "type" => "text", "title" => "Character Name"], ["name" => "reward_items", "type" => "items", "title" => "Reward Items"], ["name" => "reward_amount", "type" => "amount", "title" => "Reward Amount"], ["name" => "reward_type", "type" => "amount_type", "title" => ""]], "order" => "date DESC"], "activityrewards_logs" => ["table" => "IMPERIAMUCMS_ACTIVITY_REWARDS_LOGS", "columns" => [["name" => "Date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "Period", "type" => "text", "title" => "Period"], ["name" => "RewardItems", "type" => "items", "title" => "Reward Items"], ["name" => "Reward", "type" => "amount", "title" => "Reward Amount"], ["name" => "RewardType", "type" => "amount_type", "title" => ""]], "order" => "Date DESC"], "market_logs" => ["table" => "IMPERIAMUCMS_MARKET_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "buyer", "type" => "text", "title" => "Buyer"], ["name" => "seller", "type" => "text", "title" => "Seller"], ["name" => "item", "type" => "items", "title" => "Item"], ["name" => "type", "type" => "text", "title" => "Type"]], "order" => "date DESC"], "vip_logs" => ["table" => "IMPERIAMUCMS_VIP_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "type", "type" => "text", "title" => "Type"], ["name" => "price", "type" => "text", "title" => "Price"], ["name" => "length", "type" => "text", "title" => "Length"], ["name" => "package_id", "type" => "text", "title" => "PackageID"]], "order" => "date DESC"], "exchange_logs" => ["table" => "IMPERIAMUCMS_EXCHANGE_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "exchange_amount", "type" => "amount_e", "title" => "Amount"], ["name" => "exchange_type", "type" => "amount_type_e", "title" => ""], ["name" => "reward_amount", "type" => "amount_e", "title" => "Amount"], ["name" => "reward_type", "type" => "amount_type_e", "title" => ""]], "order" => "date DESC"], "change_class_logs" => ["table" => "IMPERIAMUCMS_CHANGE_CLASS_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "Name", "type" => "text", "title" => "Character Name"], ["name" => "OldClass", "type" => "class", "title" => "Old Class"], ["name" => "NewClass", "type" => "class", "title" => "New Class"], ["name" => "price", "type" => "amount_e", "title" => "Price"], ["name" => "price_type", "type" => "amount_type_e", "title" => ""]], "order" => "date DESC"], "change_name_logs" => ["table" => "IMPERIAMUCMS_CHANGE_NAME_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "OldName", "type" => "text", "title" => "Old Name"], ["name" => "NewName", "type" => "text", "title" => "New Name"], ["name" => "price", "type" => "amount_e", "title" => "Price"], ["name" => "price_type", "type" => "amount_type_e", "title" => ""]], "order" => "date DESC"], "transfer_char_logs" => ["table" => "IMPERIAMUCMS_TRANSFER_CHAR_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "Name", "type" => "text", "title" => "Name"], ["name" => "OldAccountID", "type" => "text", "title" => "Old AccountID"], ["name" => "NewAccountID", "type" => "text", "title" => "New AccountID"], ["name" => "price", "type" => "amount_e", "title" => "Price"], ["name" => "price_type", "type" => "amount_type_e", "title" => ""]], "order" => "date DESC"], "transfer_coins_logs" => ["table" => "IMPERIAMUCMS_TRANSFER_COINS_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "OldAccountID", "type" => "text", "title" => "Old AccountID"], ["name" => "NewAccountID", "type" => "text", "title" => "New AccountID"], ["name" => "amount", "type" => "amount_e", "title" => "Price"], ["name" => "amount_type", "type" => "amount_type_e", "title" => ""], ["name" => "message", "type" => "text", "title" => "Message"]], "order" => "date DESC"], "reset_logs" => ["table" => "IMPERIAMUCMS_CHARACTER_PROGRESS_LOGS", "columns" => [["name" => "Date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "Name", "type" => "text", "title" => "Character Name"], ["name" => "OldValue", "type" => "text", "title" => "Old Reset"], ["name" => "NewValue", "type" => "text", "title" => "New Reset"], ["name" => "IP", "type" => "text", "title" => "IP Address"]], "order" => "Date DESC", "where" => "Type = '1' AND NewValue > 0"], "greset_logs" => ["table" => "IMPERIAMUCMS_CHARACTER_PROGRESS_LOGS", "columns" => [["name" => "Date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "Name", "type" => "text", "title" => "Character Name"], ["name" => "OldValue", "type" => "text", "title" => "Old Grand Reset"], ["name" => "NewValue", "type" => "text", "title" => "New Grand Reset"], ["name" => "IP", "type" => "text", "title" => "IP Address"]], "order" => "Date DESC", "where" => "Type = '2' AND NewValue > 0"], "clear_inv_logs" => ["table" => "IMPERIAMUCMS_CLEAR_INV_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "Name", "type" => "text", "title" => "Character Name"], ["name" => "IP", "type" => "text", "title" => "IP Address"], ["name" => "old_inventory", "name2" => "CONVERT(VARCHAR(MAX), old_inventory, 2) AS old_inventory", "type" => "input-text", "input-width" => "400px", "title" => "Inventory"]], "order" => "date DESC"], "gmcp_edit_char_logs" => ["table" => "IMPERIAMUCMS_EDIT_CHAR_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "updatedBy", "type" => "text", "title" => "Updated By"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "Name", "type" => "text", "title" => "Character Name"], ["name" => "ip", "type" => "text", "title" => "IP Address"], ["name" => "log", "type" => "text", "title" => "Log"]], "order" => "date DESC"], "webshop_logs" => ["table" => "IMPERIAMUCMS_WEBSHOP_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "item", "type" => "items", "title" => "Item"], ["name" => "price", "type" => "amount_c", "title" => "Price"], ["name" => "price_type", "type" => "amount_type_c", "title" => ""]], "order" => "date DESC"], "cashshop_logs" => ["table" => "IMPERIAMUCMS_CASHSHOP_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "item_id", "type" => "text", "title" => "Item ID"], ["name" => "item_name", "type" => "text", "title" => "Item Name"], ["name" => "price", "type" => "amount_e", "title" => "Price"], ["name" => "price_type", "type" => "amount_type_e", "title" => ""], ["name" => "target", "type" => "text", "title" => "Gifted to (Character)"], ["name" => "ip", "type" => "text", "title" => "IP Address"]], "order" => "date DESC"], "achievements_logs" => ["table" => "IMPERIAMUCMS_ACHIEVEMENTS_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "Name", "type" => "text", "title" => "Character Name"], ["name" => "achiev_uid", "type" => "text", "title" => "Achievement UID"], ["name" => "achiev_stage", "type" => "text", "title" => "Achievement Stage"], ["name" => "reward", "type" => "text", "title" => "Reward"]], "order" => "date DESC"], "promo_logs" => ["table" => "IMPERIAMUCMS_PROMO_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "Code", "type" => "text", "title" => "Code"]], "order" => "date DESC"], "lottery_reward_logs" => ["table" => "IMPERIAMUCMS_LOTTERY_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "lottery_id", "type" => "text", "title" => "Lottery ID"], ["name" => "reward", "type" => "amount_e", "title" => "Reward"], ["name" => "reward_type", "type" => "amount_type_e", "title" => ""]], "order" => "date DESC"], "latestpaypal" => ["table" => "IMPERIAMUCMS_PAYPAL_TRANSACTIONS", "columns" => [["name" => "transaction_date", "type" => "timestamp", "title" => "Date"], ["name" => "transaction_id", "type" => "text", "title" => "Transaction ID"], ["name" => "user_id", "type" => "userid", "title" => "AccountID"], ["name" => "payment_amount", "type" => "amount_money", "title" => "Donation Amount"], ["name" => "payment_currency", "type" => "amount_type", "title" => ""], ["name" => "reward_amount", "type" => "amount_e", "title" => "Reward Amount"], ["name" => "reward_type", "type" => "amount_type", "title" => ""], ["name" => "paypal_email", "type" => "text", "title" => "PayPal Email"], ["name" => "transaction_status", "type" => "status", "title" => "Status"]], "order" => "transaction_date DESC"], "latestpw" => ["table" => "IMPERIAMUCMS_PW_TRANSACTIONS", "columns" => [["name" => "transaction_date", "type" => "timestamp", "title" => "Date"], ["name" => "transaction_id", "type" => "text", "title" => "Transaction ID"], ["name" => "user_id", "type" => "userid", "title" => "AccountID"], ["name" => "credits_amount", "type" => "text", "title" => "Reward Amount"], ["name" => "type", "type" => "text", "title" => "Type"]], "order" => "transaction_date DESC"], "startingkit_logs" => ["table" => "IMPERIAMUCMS_STARTING_KIT_LOGS", "columns" => [["name" => "date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "Name", "type" => "text", "title" => "Character Name"], ["name" => "kit_id", "type" => "text", "title" => "Kit ID"]], "order" => "date DESC"], "creditsmanager" => ["table" => "IMPERIAMUCMS_CREDITS_LOGS", "columns" => [["name" => "log_date", "type" => "timestamp", "title" => "Date"], ["name" => "log_config", "type" => "text", "title" => "Config"], ["name" => "log_identifier", "type" => "text", "title" => "Identifier Value"], ["name" => "log_credits", "type" => "text", "title" => "Credits"], ["name" => "log_transaction", "type" => "transaction", "title" => "Transaction"], ["name" => "log_module", "type" => "text", "title" => "Module"], ["name" => "log_ip", "type" => "text", "title" => "IP"], ["name" => "log_inadmincp", "type" => "yes/no", "title" => "AdminCP"]], "order" => "log_date DESC"], "newregistrations" => ["table" => config("SQL_USE_2_DB", true) ? "[" . config("SQL_DB_2_NAME", true) . "].[dbo].[MEMB_INFO]" : "MEMB_INFO", "columns" => [["name" => "appl_days", "type" => "date", "title" => "Date"], ["name" => "memb_guid", "type" => "text", "title" => "ID"], ["name" => "memb___id", "type" => "text", "title" => "AccountID"], ["name" => "mail_addr", "type" => "text", "title" => "Email"], ["name" => "", "type" => "acc-info", "title" => "Action"]], "order" => "appl_days DESC"], "transfercharacterserver_logs" => ["table" => "IMPERIAMUCMS_TRANSFER_CHAR_SERVER_LOGS", "columns" => [["name" => "Date", "type" => "date", "title" => "Date"], ["name" => "AccountID", "type" => "text", "title" => "AccountID"], ["name" => "OldName", "type" => "text", "title" => "Old Character Name"], ["name" => "NewName", "type" => "text", "title" => "New Character Name"]], "order" => "Date DESC"]];
    return $pages;
}

?>