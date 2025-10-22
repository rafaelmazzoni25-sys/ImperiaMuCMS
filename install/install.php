<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (isset($_POST["configok"])) {
    if (isset($_POST["import_data"])) {
        include "database.php";
        $queryError = false;
        $queryReport = "";
        $manualQueries = "";
        $check1 = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CREDITS_CONFIG");
        if (is_array($check1)) {
            $dB->query("DELETE FROM IMPERIAMUCMS_CREDITS_CONFIG");
        }
        $check2 = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CRON");
        if (is_array($check2)) {
            $dB->query("DELETE FROM IMPERIAMUCMS_CRON");
        }
        $check3 = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_ITEMS");
        if (is_array($check3)) {
            $dB->query("DELETE FROM IMPERIAMUCMS_ITEMS");
        }
        $check4 = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_VIP_CATEGORIES");
        if (is_array($check4)) {
            $dB->query("DELETE FROM IMPERIAMUCMS_VIP_CATEGORIES");
        }
        $check5 = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_VOTE_SITES");
        if (is_array($check5)) {
            $dB->query("DELETE FROM IMPERIAMUCMS_VOTE_SITES");
        }
        $check6 = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_ITEMS");
        if (is_array($check6)) {
            $dB->query("DELETE FROM IMPERIAMUCMS_WEBSHOP_ITEMS");
        }
        $check7 = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_DATA_ANCIENT_SETS");
        if (is_array($check7)) {
            $dB->query("DELETE FROM IMPERIAMUCMS_DATA_ANCIENT_SETS");
        }
        $check8 = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_DATA_ANCIENT_ITEMS");
        if (is_array($check8)) {
            $dB->query("DELETE FROM IMPERIAMUCMS_DATA_ANCIENT_ITEMS");
        }
        $check9 = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_ERRTELS");
        if (is_array($check9)) {
            $dB->query("DELETE FROM IMPERIAMUCMS_WEBSHOP_ERRTELS");
        }
        $check10 = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_WEBSHOP_HARMONY");
        if (is_array($check10)) {
            $dB->query("DELETE FROM IMPERIAMUCMS_WEBSHOP_HARMONY");
        }
        $check11 = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_DATA_SOCKETS");
        if (is_array($check11)) {
            $dB->query("DELETE FROM IMPERIAMUCMS_DATA_SOCKETS");
        }
        $check12 = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_MU_LORDS_RANKS");
        if (is_array($check12)) {
            $dB->query("DELETE FROM IMPERIAMUCMS_MU_LORDS_RANKS");
        }
        if ($config["MEMB_CREDITS_MEMUONLINE"]) {
            if (100 <= $config["server_files_season"]) {
                $data1 = $dB->query($import["imperiamucms_data1_2_2"]);
            } else {
                $data1 = $dB->query($import["imperiamucms_data1_2_1"]);
            }
        } else {
            if (100 <= $config["server_files_season"]) {
                $data1 = $dB->query($import["imperiamucms_data1_1_2"]);
            } else {
                $data1 = $dB->query($import["imperiamucms_data1_1_1"]);
            }
        }
        $data2 = $dB->query($import["imperiamucms_data2"]);
        $data3 = $dB->query($import["imperiamucms_data3"]);
        $data10 = $dB->query($import["imperiamucms_data10"]);
        $data17 = $dB->query($import["imperiamucms_data17"]);
        $data18 = $dB->query($import["imperiamucms_data18"]);
        $data19 = $dB->query($import["imperiamucms_data19"]);
        $data20 = $dB->query($import["imperiamucms_data20"]);
        $data21_1 = $dB->query($import["imperiamucms_data21_1"]);
        $data21_2 = $dB->query($import["imperiamucms_data21_2"]);
        $data21_3 = $dB->query($import["imperiamucms_data21_3"]);
        $data21_4 = $dB->query($import["imperiamucms_data21_4"]);
        $data21_5 = $dB->query($import["imperiamucms_data21_5"]);
        $data21_6 = $dB->query($import["imperiamucms_data21_6"]);
        $data21_7 = $dB->query($import["imperiamucms_data21_7"]);
        $data22 = $dB->query($import["imperiamucms_data22"]);
        $data24 = $dB->query($import["imperiamucms_data24"]);
        $data25 = $dB->query($import["imperiamucms_data25"]);
        $data_items = [];
        $data_items[1] = $dB->query($import["imperiamucms_data_items_1"]);
        $data_items[2] = $dB->query($import["imperiamucms_data_items_2"]);
        $data_items[3] = $dB->query($import["imperiamucms_data_items_3"]);
        $data_items[4] = $dB->query($import["imperiamucms_data_items_4"]);
        $data_items[5] = $dB->query($import["imperiamucms_data_items_5"]);
        $data_items[6] = $dB->query($import["imperiamucms_data_items_6"]);
        $data_items[7] = $dB->query($import["imperiamucms_data_items_7"]);
        $data_items[8] = $dB->query($import["imperiamucms_data_items_8"]);
        $data_items[9] = $dB->query($import["imperiamucms_data_items_9"]);
        $data_items[10] = $dB->query($import["imperiamucms_data_items_10"]);
        $data_items[11] = $dB->query($import["imperiamucms_data_items_11"]);
        $data_items[12] = $dB->query($import["imperiamucms_data_items_12"]);
        $data_items[13] = $dB->query($import["imperiamucms_data_items_13"]);
        $data_items[14] = $dB->query($import["imperiamucms_data_items_14"]);
        $data_items[15] = $dB->query($import["imperiamucms_data_items_15"]);
        $dB->query("UPDATE [dbo].[IMPERIAMUCMS_ITEMS] SET [use_harmony] = 0 WHERE type > 11");
        $data_webshop_items = [];
        $data_webshop_items[1] = $dB->query($import["imperiamucms_data_webshop_items_1"]);
        $data_webshop_items[2] = $dB->query($import["imperiamucms_data_webshop_items_2"]);
        $data_webshop_items[3] = $dB->query($import["imperiamucms_data_webshop_items_3"]);
        $data_webshop_items[4] = $dB->query($import["imperiamucms_data_webshop_items_4"]);
        $data_webshop_items[5] = $dB->query($import["imperiamucms_data_webshop_items_5"]);
        $data_webshop_items[6] = $dB->query($import["imperiamucms_data_webshop_items_6"]);
        if ($data1) {
            $queryReport .= "<li class=\"success\">[DATA] Credits successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Credits import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data1"] . "</pre><br>";
        }
        if ($data2) {
            $queryReport .= "<li class=\"success\">[DATA] Crons successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Crons import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data2"] . "</pre><br>";
        }
        if ($data3) {
            $queryReport .= "<li class=\"success\">[DATA] Data #3 successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Data #3 import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data3"] . "</pre><br>";
        }
        if ($data10) {
            $queryReport .= "<li class=\"success\">[DATA] VIP & Votes successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] VIP & Votes import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data10"] . "</pre><br>";
        }
        if ($data17) {
            $queryReport .= "<li class=\"success\">[DATA] Webshop #7 successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Webshop #7 import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data17"] . "</pre><br>";
        }
        if ($data18) {
            $queryReport .= "<li class=\"success\">[DATA] Webshop #8 successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Webshop #8 import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data18"] . "</pre><br>";
        }
        if ($data19) {
            $queryReport .= "<li class=\"success\">[DATA] Webshop #9 successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Webshop #9 import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data19"] . "</pre><br>";
        }
        if ($data20) {
            $queryReport .= "<li class=\"success\">[DATA] Webshop #10 successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Webshop #10 import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data20"] . "</pre><br>";
        }
        if ($data21_1) {
            $queryReport .= "<li class=\"success\">[DATA] Webshop #11 successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Webshop #11 import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data21_1"] . "</pre><br>";
        }
        if ($data21_2) {
            $queryReport .= "<li class=\"success\">[DATA] Webshop #12 successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Webshop #12 import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data21_2"] . "</pre><br>";
        }
        if ($data21_3) {
            $queryReport .= "<li class=\"success\">[DATA] Webshop #13 successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Webshop #13 import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data21_3"] . "</pre><br>";
        }
        if ($data21_4) {
            $queryReport .= "<li class=\"success\">[DATA] Webshop #14 successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Webshop #14 import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data21_4"] . "</pre><br>";
        }
        if ($data21_5) {
            $queryReport .= "<li class=\"success\">[DATA] Webshop #15 successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Webshop #15 import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data21_5"] . "</pre><br>";
        }
        if ($data21_6) {
            $queryReport .= "<li class=\"success\">[DATA] Webshop #16 successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Webshop #16 import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data21_6"] . "</pre><br>";
        }
        if ($data21_7) {
            $queryReport .= "<li class=\"success\">[DATA] Webshop #17 successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Webshop #17 import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data21_7"] . "</pre><br>";
        }
        if ($data22) {
            $queryReport .= "<li class=\"success\">[DATA] MU Lords successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] MU Lords import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data22"] . "</pre><br>";
        }
        if ($data24) {
            $queryReport .= "<li class=\"success\">[DATA] Errtels successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Errtels import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data24"] . "</pre><br>";
        }
        if ($data25) {
            $queryReport .= "<li class=\"success\">[DATA] Webshop categories successfully imported.</li>";
        } else {
            $queryError = true;
            $queryReport .= "<li class=\"fail\">[DATA] Webshop categories import failed.</li>";
            $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data25"] . "</pre><br>";
        }
        if (is_array($data_items)) {
            $queryCounter = 1;
            foreach ($data_items as $thisQuery) {
                if ($thisQuery) {
                    $queryReport .= "<li class=\"success\">[DATA] Items #" . $queryCounter . " successfully imported.</li>";
                } else {
                    $queryError = true;
                    $queryReport .= "<li class=\"fail\">[DATA] Items #" . $queryCounter . " import failed.</li>";
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data_items_" . $queryCounter] . "</pre><br>";
                }
                $queryCounter++;
            }
        }
        if (is_array($data_webshop_items)) {
            $queryCounter = 1;
            foreach ($data_webshop_items as $thisQuery) {
                if ($thisQuery) {
                    $queryReport .= "<li class=\"success\">[DATA] Webshop Items #" . $queryCounter . " successfully imported.</li>";
                } else {
                    $queryError = true;
                    $queryReport .= "<li class=\"fail\">[DATA] Webshop Items #" . $queryCounter . " import failed.</li>";
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_data_webshop_items_" . $queryCounter] . "</pre><br>";
                }
                $queryCounter++;
            }
        }
        echo "\r\n        <div class=\"page-header\">\r\n            <h1>ImperiaMuCMS Install <small>Step: Import Database</small>\r\n            </h1>\r\n        </div>\r\n        <div class=\"panel panel-default\">\r\n            <div class=\"panel-body\">\r\n                <div class=\"row\">\r\n                    <form method=\"post\" action=\"\">\r\n                        <div class=\"col-md-3\">\r\n                            <ul class=\"nav nav-pills nav-stacked no-hover\">\r\n                                <li class=\"done\">\r\n                                    <a><i class=\"fa fa-check\"></i>&nbsp;&nbsp;System Check</a>\r\n                                </li>\r\n                                <li class=\"done\">\r\n                                    <a><i class=\"fa fa-check\"></i>&nbsp;&nbsp;License</a>\r\n                                </li>\r\n                                <li class=\"done\">\r\n                                    <a><i class=\"fa fa-check\"></i>&nbsp;&nbsp;Website Config</a>\r\n                                </li>\r\n                                <li class=\"done\">\r\n                                    <a><i class=\"fa fa-circle\"></i>&nbsp;&nbsp;Install</a>\r\n                                </li>\r\n                            </ul>\r\n                        </div>\r\n                        <div class=\"col-md-9\">";
        if ($queryError) {
            echo "\r\n            <div class=\"alert alert-danger\" role=\"alert\">\r\n                <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>\r\n                <span class=\"sr-only\">Warning:</span>\r\n                Some queries failed. Please execute all queries below directly in Microsoft SQL Server Management Studio.\r\n                  After that installation will be complete.\r\n            </div>\r\n            <h4 class=\"text-muted\">Now you can navigate to includes/config.php and configure server countdown, server time zone, admin and GM access privileges etc.</h4>\r\n            <h3><font color=\"red\">For security reasons remove or rename installation folder.</font></h3>";
            echo $manualQueries;
        } else {
            echo "\r\n            <div class=\"alert alert-success\" role=\"alert\">\r\n                <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>\r\n                <span class=\"sr-only\">Success:</span>\r\n                Data were successfully imported into database.\r\n            </div>\r\n            <h4 class=\"text-muted\">Installation is now complete. Now you can navigate to includes/config.php and configure server countdown, server time zone, admin and GM access privileges etc.</h4>\r\n            <h3><font color=\"red\">For security reasons remove or rename installation folder.</font></h3>";
        }
        echo "\r\n                            <ul class=\"list-unstyled\">\r\n                                " . $queryReport . "\r\n                            </ul>\r\n                        </div>\r\n                    </form>\r\n                </div>\r\n            </div>\r\n        </div>";
    } else {
        if (isset($_POST["import_struct"])) {
            include "database.php";
            $queryError = false;
            $queryReport = "";
            $manualQueries = "";
            $character1 = $dB->query($import["character1"]);
            $character2 = $dB->query($import["character2"]);
            if ($config["SQL_USE_2_DB"]) {
                $memb_info1 = $dB2->query($import["memb_info1"]);
                $memb_info2 = $dB2->query($import["memb_info2"]);
                $memb_info3 = $dB2->query($import["memb_info3"]);
                $memb_info4 = $dB2->query($import["memb_info4"]);
                $memb_stat1 = $dB2->query($import["memb_stat1"]);
                $wz_connect_memb = true;
                $wz_disconnect_memb = true;
            } else {
                $memb_info1 = $dB->query($import["memb_info1"]);
                $memb_info2 = $dB->query($import["memb_info2"]);
                $memb_info3 = $dB->query($import["memb_info3"]);
                $memb_info4 = $dB->query($import["memb_info4"]);
                $memb_stat1 = $dB->query($import["memb_stat1"]);
                $wz_connect_memb = true;
                $wz_disconnect_memb = true;
            }
            $structure1 = $dB->query($import["imperiamucms_structure1"]);
            $structure2 = $dB->query($import["imperiamucms_structure2"]);
            $structure3 = $dB->query($import["imperiamucms_structure3"]);
            $structure4 = $dB->query($import["imperiamucms_structure4"]);
            $structure5 = $dB->query($import["imperiamucms_structure5"]);
            $structure6 = $dB->query($import["imperiamucms_structure6"]);
            $structure7 = $dB->query($import["imperiamucms_structure7"]);
            $structure8 = $dB->query($import["imperiamucms_structure8"]);
            $structure9 = $dB->query($import["imperiamucms_structure9"]);
            $structure10 = $dB->query($import["imperiamucms_structure10"]);
            $structure11 = $dB->query($import["imperiamucms_structure11"]);
            $structure12 = $dB->query($import["imperiamucms_structure12"]);
            $structure13 = $dB->query($import["imperiamucms_structure13"]);
            $structure14 = $dB->query($import["imperiamucms_structure14"]);
            $structure15 = $dB->query($import["imperiamucms_structure15"]);
            $structure16 = $dB->query($import["imperiamucms_structure16"]);
            $structure17 = $dB->query($import["imperiamucms_structure17"]);
            $structure18 = $dB->query($import["imperiamucms_structure18"]);
            $structure19 = $dB->query($import["imperiamucms_structure19"]);
            $structure20 = $dB->query($import["imperiamucms_structure20"]);
            $structure21 = $dB->query($import["imperiamucms_structure21"]);
            $structure22 = $dB->query($import["imperiamucms_structure22"]);
            $structure23 = $dB->query($import["imperiamucms_structure23"]);
            $structure24 = $dB->query($import["imperiamucms_structure24"]);
            $structure25 = $dB->query($import["imperiamucms_structure25"]);
            $structure26 = $dB->query($import["imperiamucms_structure26"]);
            $structure27 = $dB->query($import["imperiamucms_structure27"]);
            if ($config["MEMB_CREDITS_MEMUONLINE"]) {
                $structure28 = $dB2->query($import["imperiamucms_structure28"]);
            } else {
                $structure28 = $dB->query($import["imperiamucms_structure28"]);
            }
            $structure29 = $dB->query($import["imperiamucms_structure29"]);
            $structure30 = $dB->query($import["imperiamucms_structure30"]);
            $structure31 = $dB->query($import["imperiamucms_structure31"]);
            $structure32 = $dB->query($import["imperiamucms_structure32"]);
            $structure33 = $dB->query($import["imperiamucms_structure33"]);
            $structure34 = $dB->query($import["imperiamucms_structure34"]);
            $structure35 = $dB->query($import["imperiamucms_structure35"]);
            $structure36 = $dB->query($import["imperiamucms_structure36"]);
            $structure37 = $dB->query($import["imperiamucms_structure37"]);
            $structure38 = $dB->query($import["imperiamucms_structure38"]);
            $structure39 = $dB->query($import["imperiamucms_structure39"]);
            $structure40 = $dB->query($import["imperiamucms_structure40"]);
            $structure41 = $dB->query($import["imperiamucms_structure41"]);
            if ($config["SQL_USE_2_DB"]) {
                $structure42 = $dB->query($import["imperiamucms_structure42"]);
            }
            $structure43 = $dB->query($import["imperiamucms_structure43"]);
            $structure44 = $dB->query($import["imperiamucms_structure44"]);
            $structure45 = $dB->query($import["imperiamucms_structure45"]);
            $structure46 = $dB->query($import["imperiamucms_structure46"]);
            $structure47 = $dB->query($import["imperiamucms_structure47"]);
            if ($character1) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Column Character.RESETS successfully added.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Column Character.RESETS failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["character1"] . "</pre><br>";
            }
            if ($character2) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Column Character.Grand_Resets successfully added.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Column Character.Grand_Resets failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["character2"] . "</pre><br>";
            }
            if ($memb_info1) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Column MEMB_INFO.SecretQuestion successfully added.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Column MEMB_INFO.SecretQuestion failed.</li>";
                if ($config["SQL_USE_2_DB"]) {
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["memb_info1"] . "</pre><br>";
                } else {
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_2_NAME"] . "]<br>GO<br>" . $import["memb_info1"] . "</pre><br>";
                }
            }
            if ($memb_info2) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Column MEMB_INFO.SecretAnswer successfully added.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Column MEMB_INFO.SecretAnswer failed.</li>";
                if ($config["SQL_USE_2_DB"]) {
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["memb_info2"] . "</pre><br>";
                } else {
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_2_NAME"] . "]<br>GO<br>" . $import["memb_info2"] . "</pre><br>";
                }
            }
            if ($memb_info3) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Column MEMB_INFO.Country successfully added.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Column MEMB_INFO.Country failed.</li>";
                if ($config["SQL_USE_2_DB"]) {
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["memb_info3"] . "</pre><br>";
                } else {
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_2_NAME"] . "]<br>GO<br>" . $import["memb_info3"] . "</pre><br>";
                }
            }
            if ($memb_info4) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Column MEMB_INFO.FirstName successfully added.</li>";
                $queryReport .= "<li class=\"success\">[STRUCTURE] Column MEMB_INFO.LastName successfully added.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Column MEMB_INFO.FirstName failed.</li>";
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Column MEMB_INFO.LastName failed.</li>";
                if ($config["SQL_USE_2_DB"]) {
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["memb_info4"] . "</pre><br>";
                } else {
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_2_NAME"] . "]<br>GO<br>" . $import["memb_info4"] . "</pre><br>";
                }
            }
            if ($memb_stat1) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Column MEMB_STAT.OnlineTime successfully added.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Column MEMB_STAT.OnlineTime failed.</li>";
                if ($config["SQL_USE_2_DB"]) {
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["memb_stat1"] . "</pre><br>";
                } else {
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_2_NAME"] . "]<br>GO<br>" . $import["memb_stat1"] . "</pre><br>";
                }
            }
            if ($structure1) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Account Logs successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Account Logs import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure1"] . "</pre><br>";
            }
            if ($structure2) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Achievements successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Achievements import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure2"] . "</pre><br>";
            }
            if ($structure3) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Sessions successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Sessions import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure3"] . "</pre><br>";
            }
            if ($structure4) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Bans successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Bans import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure4"] . "</pre><br>";
            }
            if ($structure5) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Bug Tracker successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Bug Tracker import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure5"] . "</pre><br>";
            }
            if ($structure6) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Changelogs successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Changelogs import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure6"] . "</pre><br>";
            }
            if ($structure7) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Credits System successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Credits System import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure7"] . "</pre><br>";
            }
            if ($structure8) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Crons successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Crons import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure8"] . "</pre><br>";
            }
            if ($structure9) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] CS History successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] CS History import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure9"] . "</pre><br>";
            }
            if ($structure10) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Downloads successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Downloads import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure10"] . "</pre><br>";
            }
            if ($structure11) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Dual Stats & Dual Skill Tree successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Dual Stats & Dual Skill Tree import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure11"] . "</pre><br>";
            }
            if ($structure12) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Login successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Login import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure12"] . "</pre><br>";
            }
            if ($structure13) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Market successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Market import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure13"] . "</pre><br>";
            }
            if ($structure14) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] News successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] News import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure14"] . "</pre><br>";
            }
            if ($structure15) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Password Change successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Password Change import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure15"] . "</pre><br>";
            }
            if ($structure16) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] PayPal & Pay.nl successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] PayPal & Pay.nl import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure16"] . "</pre><br>";
            }
            if ($structure17) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Plugins successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Plugins import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure17"] . "</pre><br>";
            }
            if ($structure18) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Promo System successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Promo System import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure18"] . "</pre><br>";
            }
            if ($structure19) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Paymentwall successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Paymentwall import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure19"] . "</pre><br>";
            }
            if ($structure20) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Recruit successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Recruit import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure20"] . "</pre><br>";
            }
            if ($structure21) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Register successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Register import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure21"] . "</pre><br>";
            }
            if ($structure22) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] SuperRewards successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] SuperRewards import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure22"] . "</pre><br>";
            }
            if ($structure23) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Tickets successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Tickets import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure23"] . "</pre><br>";
            }
            if ($structure24) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] VIP successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] VIP import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure24"] . "</pre><br>";
            }
            if ($structure25) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Votes successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Votes import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure25"] . "</pre><br>";
            }
            if ($structure26) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Web Bank successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Web Bank import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure26"] . "</pre><br>";
            }
            if ($structure27) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Webshop successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Webshop import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure27"] . "</pre><br>";
            }
            if ($structure28) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Credits successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Credits import failed.</li>";
                if ($config["MEMB_CREDITS_MEMUONLINE"]) {
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_2_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure28"] . "</pre><br>";
                } else {
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure28"] . "</pre><br>";
                }
            }
            if ($structure29) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Merchant successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Merchant import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure29"] . "</pre><br>";
            }
            if ($structure30) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] MU Lords successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] MU Lords import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure30"] . "</pre><br>";
            }
            if ($structure31) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Networking successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Networking import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure31"] . "</pre><br>";
            }
            if ($structure32) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Lottery successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Lottery import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure32"] . "</pre><br>";
            }
            if ($structure33) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Exchange successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Exchange import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure33"] . "</pre><br>";
            }
            if ($structure34) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Homepay & PayU successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Homepay & PayU import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure34"] . "</pre><br>";
            }
            if ($structure35) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Auctions successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Auctions import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure35"] . "</pre><br>";
            }
            if ($structure36) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Guides successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Guides import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure36"] . "</pre><br>";
            }
            if ($structure37) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Claim a reward successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Claim a reward import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure37"] . "</pre><br>";
            }
            if ($structure38) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Starting kit & Logs successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Starting kit & Logs import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure38"] . "</pre><br>";
            }
            if ($structure39) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Cash Shop successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Cash Shop import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure39"] . "</pre><br>";
            }
            if ($structure40) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Wheel of Fortune successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Wheel of Fortune import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure40"] . "</pre><br>";
            }
            if ($structure41) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Trigger tables successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Trigger tables import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure41"] . "</pre><br>";
            }
            if ($config["SQL_USE_2_DB"]) {
                if ($structure42) {
                    $queryReport .= "<li class=\"success\">[STRUCTURE] Me_MuOnline Trigger tables successfully imported.</li>";
                } else {
                    $queryError = true;
                    $queryReport .= "<li class=\"fail\">[STRUCTURE] Me_MuOnline Trigger tables import failed.</li>";
                    $manualQueries .= "<pre>USE [" . $config["SQL_DB_2_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure42"] . "</pre><br>";
                }
            }
            if ($structure43) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Architect tables successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Architect tables import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure43"] . "</pre><br>";
            }
            if ($structure44) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Tables #44 successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Tables #44 import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure44"] . "</pre><br>";
            }
            if ($structure45) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Tables #45 successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Tables #45 import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure45"] . "</pre><br>";
            }
            if ($structure46) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Tables #46 successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Tables #46 import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure46"] . "</pre><br>";
            }
            if ($structure47) {
                $queryReport .= "<li class=\"success\">[STRUCTURE] Tables #47 successfully imported.</li>";
            } else {
                $queryError = true;
                $queryReport .= "<li class=\"fail\">[STRUCTURE] Tables #47 import failed.</li>";
                $manualQueries .= "<pre>USE [" . $config["SQL_DB_NAME"] . "]<br>GO<br>" . $import["imperiamucms_structure47"] . "</pre><br>";
            }
            echo "\r\n        <div class=\"page-header\">\r\n            <h1>ImperiaMuCMS Install <small>Step: Import Database</small>\r\n            </h1>\r\n        </div>\r\n        <div class=\"panel panel-default\">\r\n            <div class=\"panel-body\">\r\n                <div class=\"row\">\r\n                    <form method=\"post\" action=\"\">\r\n                        <div class=\"col-md-3\">\r\n                            <ul class=\"nav nav-pills nav-stacked no-hover\">\r\n                                <li class=\"done\">\r\n                                    <a><i class=\"fa fa-check\"></i>&nbsp;&nbsp;System Check</a>\r\n                                </li>\r\n                                <li class=\"done\">\r\n                                    <a><i class=\"fa fa-check\"></i>&nbsp;&nbsp;License</a>\r\n                                </li>\r\n                                <li class=\"done\">\r\n                                    <a><i class=\"fa fa-check\"></i>&nbsp;&nbsp;Website Config</a>\r\n                                </li>\r\n                                <li class=\"\">\r\n                                    <a><i class=\"fa fa-circle\"></i>&nbsp;&nbsp;Install</a>\r\n                                </li>\r\n                            </ul>\r\n                        </div>\r\n                        <div class=\"col-md-9\">";
            if ($queryError) {
                echo "\r\n            <div class=\"alert alert-danger\" role=\"alert\">\r\n                <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>\r\n                <span class=\"sr-only\">Warning:</span>\r\n                Some queries failed. Please execute all queries below directly in Microsoft SQL Server Management Studio.\r\n                After that you can continue on next step of database import.\r\n            </div>";
                echo $manualQueries;
            } else {
                echo "\r\n            <div class=\"alert alert-success\" role=\"alert\">\r\n                <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>\r\n                <span class=\"sr-only\">Success:</span>\r\n                Database structure was successfully imported. Please click on \"CONTINUE\" to import data.\r\n            </div>";
            }
            echo "\r\n                            <ul class=\"list-unstyled\">\r\n                                " . $queryReport . "\r\n                            </ul>\r\n                        </div>\r\n                        <div class=\"text-center\">\r\n                            <input type=\"hidden\" name=\"configok\">\r\n                            <input type=\"submit\" name=\"import_data\" value=\"CONTINUE\" class=\"btn btn-primary btn-lg\">\r\n                        </div>\r\n                    </form>\r\n                </div>\r\n            </div>\r\n        </div>";
        } else {
            echo "\r\n        <div class=\"page-header\">\r\n            <h1>ImperiaMuCMS Install\r\n                <small>Step: Import Database</small>\r\n            </h1>\r\n        </div>\r\n        <div class=\"panel panel-default\">\r\n            <div class=\"panel-body\">\r\n                <div class=\"row\">\r\n                    <form method=\"post\" action=\"\">\r\n                        <div class=\"col-md-3\">\r\n                            <ul class=\"nav nav-pills nav-stacked no-hover\">\r\n                                <li class='done'>\r\n                                    <a><i class='fa fa-check'></i>&nbsp;&nbsp;System Check</a>\r\n                                </li>\r\n                                <li class='done'>\r\n                                    <a><i class='fa fa-check'></i>&nbsp;&nbsp;License</a>\r\n                                </li>\r\n                                <li class='done'>\r\n                                    <a><i class='fa fa-check'></i>&nbsp;&nbsp;Website Config</a>\r\n                                </li>\r\n                                <li class=''>\r\n                                    <a><i class='fa fa-circle'></i>&nbsp;&nbsp;Install</a>\r\n                                </li>\r\n                            </ul>\r\n                        </div>\r\n                        <div class=\"col-md-9\">\r\n                            <h5 class=\"text-muted\">After you click on button below, ImperiaMuCMS installation will starts.\r\n                                Please, do not interupt loading page nor redirect to other URL.<br><br>\r\n                                You will be automatically redirected after the installation is complete.</h5>\r\n                        </div>\r\n                        <div class=\"text-center\">\r\n                            <input type=\"hidden\" name=\"configok\">\r\n                            <input type=\"submit\" name=\"import_struct\" value=\"START INSTALLATION\" class=\"btn btn-success btn-lg\">\r\n                        </div>\r\n                    </form>\r\n                </div>\r\n            </div>\r\n        </div>\r\n\r\n        ";
        }
    }
} else {
    echo "Direct access is not allowed.";
}

?>