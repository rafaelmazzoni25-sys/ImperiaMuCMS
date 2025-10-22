<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
function isSidebar()
{
    if (strtolower($_REQUEST["page"]) == "" || strtolower($_REQUEST["page"]) == NULL || strtolower($_REQUEST["page"]) == "news") {
        return true;
    }
    return false;
}
function check_port($ip, $port)
{
    $conn = @fsockopen($ip, $port, $errno, $errstr, 2);
    if ($conn) {
        fclose($conn);
        return true;
    }
    return false;
}
function hofChars($order)
{
    global $dB;
    return $dB->query_fetch("SELECT TOP 5 AccountID, Name, cLevel, LevelUpPoint, Class, Experience, Strength, Dexterity, Vitality, Energy, CONVERT(VARCHAR(MAX), MagicList, 2) AS MagicList, Money, Life, MaxLife, Mana, MaxMana, MapNumber, MapPosX, MapPosY, PkCount, PkLevel, PkTime, MDate, LDate, CtlCode, CONVERT(VARCHAR(MAX), Quest, 2) AS Quest, Leadership, ChatLimitTime, FruitPoint, RESETS, CONVERT(VARCHAR(MAX), Inventory, 2) AS Inventory, Married, MarryName, mLevel, mlPoint, mlExperience, mlNextExp, InventoryExpansion, WinDuels, LoseDuels, Grand_Resets FROM Character ORDER BY " . $order);
}
function hofGuilds($order)
{
    global $dB;
    return $dB->query_fetch("SELECT TOP 5 * FROM Guild ORDER BY " . $order);
}
function template_displayUserCPMenu()
{
    global $tSettings;
    if (is_array($tSettings["usercp_menu"])) {
        foreach ($tSettings["usercp_menu"] as $usercpItem) {
            if (is_array($usercpItem)) {
                $getConfig = explode("/", $usercpItem[2]);
                if (check_value($getConfig[0])) {
                    $moduleConfig = $getConfig[0];
                    if (check_value($getConfig[1])) {
                        $moduleConfig .= "." . $getConfig[1];
                    }
                    if (moduleConfigExists($moduleConfig)) {
                        $modXml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . $moduleConfig . ".xml");
                        if ($modXml->active != 0) {
                        }
                    }
                }
                switch ($usercpItem[0]) {
                    case 1:
                        $link = __BASE_URL__ . $usercpItem[2];
                        break;
                    default:
                        $link = $usercpItem[2];
                        if ($usercpItem[4]) {
                            $item = "<a href=\"" . $link . "\" title=\"" . $usercpItem[1] . "\" alt=\"" . $usercpItem[1] . "\" target=\"_blank\">" . $usercpItem[1] . "</a>";
                        } else {
                            $item = "<a href=\"" . $link . "\" title=\"" . $usercpItem[1] . "\" alt=\"" . $usercpItem[1] . "\">" . $usercpItem[1] . "</a>";
                        }
                        echo "<tr><td>" . $item . "</td></tr>";
                }
            }
        }
    }
}
function sidebarCS()
{
    loadModuleConfigs("castlesiege");
    if (mconfig("active")) {
        $ranking_data = LoadCacheData("castle_siege.cache");
        $Rankings = new Rankings();
        $cs = cs_CalculateTimeLeft();
        if (!is_null($cs)) {
            $timeleft = sec_to_hms($cs);
            echo "\r\n\t\t\t<script type=\"text/javascript\">\r\n\t\t\t\tvar csTimeStamp = " . (time() + $cs) . ";\r\n\t\t\t\tfunction displayCountdown() {\r\n\t\t\t\t\tvar timestamp = Math.floor((new Date().getTime())/1000);\r\n\t\t\t\t\tvar input_timestamp = csTimeStamp-timestamp;\r\n\t\t\t\t\tif(input_timestamp >= 1) {\r\n\t\t\t\t\t\tvar hours_module = input_timestamp % 3600;\r\n\t\t\t\t\t\tvar hours = (input_timestamp-hours_module)/3600;\r\n\t\t\t\t\t\tvar minutes_module = hours_module % 60;\r\n\t\t\t\t\t\tvar minutes = (hours_module-minutes_module)/60;\r\n\t\t\t\t\t\tvar seconds = minutes_module;\r\n\t\t\t\t\t} else {\r\n\t\t\t\t\t\tvar hours = 0;\r\n\t\t\t\t\t\tvar minutes = 0;\r\n\t\t\t\t\t\tvar seconds = 0;\r\n\t\t\t\t\t}\r\n\t\t\t\t\tdocument.getElementById(\"cscountdown\").innerHTML = hours + \"<span>h</span> \" + minutes + \"<span>m</span> \" + seconds + \"<span>s</span>\";\r\n\t\t\t\t}\r\n\t\t\t</script>\r\n\t\t\t<div id=\"castle-siege\">\r\n\t\t\t\t<table cellspacing=\"0\" cellpadding=\"0\">\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=\"cs-logo\">" . returnGuildLogo($ranking_data[1][1], 112) . "</td>\r\n\t\t\t\t\t\t<td class=\"cs-guild-info\">\r\n\t\t\t\t\t\t\t<span class=\"cs-guild-title\">" . $ranking_data[1][0] . "</span><br />\r\n\t\t\t\t\t\t\t<span>" . lang("csbanner_txt_1", true) . "</span>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t" . lang("csbanner_txt_2", true) . "<br />\r\n\t\t\t\t\t\t\t<span class=\"cs-timeleft\" id=\"cscountdown\"></span>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</table>\r\n\t\t\t</div>";
        }
    }
}
function template_displayCastleSiegeBanner()
{
    loadModuleConfigs("castlesiege");
    if (mconfig("active") && mconfig("enable_banner")) {
        $ranking_data = LoadCacheData("castle_siege.cache");
        $Rankings = new Rankings();
        $cs = cs_CalculateTimeLeft();
        if (!is_null($cs)) {
            $timeleft = sec_to_hms($cs);
            echo "\r\n\t\t\t<script type=\"text/javascript\">\r\n\t\t\t\tvar csTimeStamp = " . (time() + $cs) . ";\r\n\t\t\t\tfunction displayCountdown() {\r\n\t\t\t\t\tvar timestamp = Math.floor((new Date().getTime())/1000);\r\n\t\t\t\t\tvar input_timestamp = csTimeStamp-timestamp;\r\n\t\t\t\t\tif(input_timestamp >= 1) {\r\n\t\t\t\t\t\tvar hours_module = input_timestamp % 3600;\r\n\t\t\t\t\t\tvar hours = (input_timestamp-hours_module)/3600;\r\n\t\t\t\t\t\tvar minutes_module = hours_module % 60;\r\n\t\t\t\t\t\tvar minutes = (hours_module-minutes_module)/60;\r\n\t\t\t\t\t\tvar seconds = minutes_module;\r\n\t\t\t\t\t} else {\r\n\t\t\t\t\t\tvar hours = 0;\r\n\t\t\t\t\t\tvar minutes = 0;\r\n\t\t\t\t\t\tvar seconds = 0;\r\n\t\t\t\t\t}\r\n\t\t\t\t\tdocument.getElementById(\"cscountdown\").innerHTML = hours + \"<span>h</span> \" + minutes + \"<span>m</span> \" + seconds + \"<span>s</span>\";\r\n\t\t\t\t}\r\n\t\t\t</script>\r\n\t\t\t<div id=\"castle-siege\">\r\n\t\t\t\t<table cellspacing=\"0\" cellpadding=\"0\">\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td class=\"cs-logo\">" . returnGuildLogo($ranking_data[1][1], 112) . "</td>\r\n\t\t\t\t\t\t<td class=\"cs-guild-info\">\r\n\t\t\t\t\t\t\t<span class=\"cs-guild-title\">" . $ranking_data[1][0] . "</span><br />\r\n\t\t\t\t\t\t\t<span>" . lang("csbanner_txt_1", true) . "</span>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t" . lang("csbanner_txt_2", true) . "<br />\r\n\t\t\t\t\t\t\t<span class=\"cs-timeleft\" id=\"cscountdown\"></span>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</table>\r\n\t\t\t</div>";
        }
    }
}

?>