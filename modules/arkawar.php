<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("arkawar")) {
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("arkawar_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $arkaWinners = $dB->query_fetch("\r\n              SELECT TOP 2 ab.G_Name as G_Name, CONVERT(date, ab.WinDate) as WinDate, ab.OuccupyObelisk as OuccupyObelisk, \r\n                ab.ObeliskGroup as ObeliskGroup, CONVERT(varchar(max), g.G_Mark, 2) as G_Mark, g.G_Master as G_Master\r\n              FROM IGC_ARCA_BATTLE_WIN_GUILD_INFO ab\r\n              INNER JOIN Guild g ON ab.G_Name = g.G_Name\r\n              ORDER BY WinDate DESC\r\n            ");
            if (is_array($arkaWinners)) {
                $battleDays = [];
                if (mconfig("monday")) {
                    array_push($battleDays, 1);
                }
                if (mconfig("tuesday")) {
                    array_push($battleDays, 2);
                }
                if (mconfig("wednesday")) {
                    array_push($battleDays, 3);
                }
                if (mconfig("thursday")) {
                    array_push($battleDays, 4);
                }
                if (mconfig("friday")) {
                    array_push($battleDays, 5);
                }
                if (mconfig("saturday")) {
                    array_push($battleDays, 6);
                }
                if (mconfig("sunday")) {
                    array_push($battleDays, 7);
                }
                $battleTimeStartHour = mconfig("event_hour");
                $battleTimeStartMinute = mconfig("event_minute");
                $elements = [1 => lang("arkawar_txt_23", true), 2 => lang("arkawar_txt_24", true), 3 => lang("arkawar_txt_25", true), 4 => lang("arkawar_txt_26", true), 5 => lang("arkawar_txt_27", true)];
                $areas = [1 => lang("arkawar_txt_28", true), 2 => lang("arkawar_txt_29", true), 3 => lang("arkawar_txt_30", true)];
                $days = ["1" => "monday", "2" => "tuesday", "3" => "wednesday", "4" => "thursday", "5" => "friday", "6" => "saturday", "7" => "sunday"];
                $nextDay = NULL;
                $currDay = date("N");
                foreach ($battleDays as $thisDay) {
                    if ($currDay < $thisDay) {
                        $nextDay = $thisDay;
                        $nextBattle = strtotime("next " . $days[$nextDay]);
                    } else {
                        if ($thisDay == $currDay) {
                            $nextDay = $currDay;
                            $nextBattle = strtotime(date("Y-m-d", time()));
                        }
                    }
                    if ($nextBattle == NULL) {
                        $nextBattle = strtotime("next " . $days[$battleDays[0]]);
                    }
                    $nextBattle += $battleTimeStartHour * 3600 + $battleTimeStartMinute * 60;
                }
            }
            if (is_array($arkaWinners[1]) && $arkaWinners[0]["WinDate"] == $arkaWinners[1]["WinDate"]) {
                $show2nd = true;
                $width1 = "15%";
                $width2 = "15%";
                $width3 = "20%";
            } else {
                $show2nd = false;
                $width1 = "33%";
                $width2 = "33%";
                $width3 = "34%";
            }
            echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <thead>\r\n                <tr>\r\n                    <th colspan=\"12\">" . lang("arkawar_txt_2", true) . "</th>\r\n                </tr>\r\n            </thead>\r\n            <tbody>\r\n                <tr>\r\n                    <td rowspan=\"6\" width=\"" . $width1 . "\">" . returnGuildLogo($arkaWinners[0]["G_Mark"], 112) . "</td>\r\n                    <th width=\"" . $width2 . "\">" . lang("arkawar_txt_3", true) . "</th>\r\n                    <td width=\"" . $width3 . "\"><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($arkaWinners[0]["G_Name"]) . "/\">" . $common->replaceHtmlSymbols($arkaWinners[0]["G_Name"]) . "</a></td>";
            if ($show2nd) {
                echo "\r\n                    <td rowspan=\"6\" width=\"" . $width1 . "\">" . returnGuildLogo($arkaWinners[1]["G_Mark"], 112) . "</td>\r\n                    <th width=\"" . $width2 . "\">" . lang("arkawar_txt_3", true) . "</th>\r\n                    <td width=\"" . $width3 . "\"><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($arkaWinners[1]["G_Name"]) . "/\">" . $common->replaceHtmlSymbols($arkaWinners[1]["G_Name"]) . "</a></td>";
            }
            echo "\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"center\">" . lang("arkawar_txt_4", true) . "</th>\r\n                    <td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($arkaWinners[0]["G_Master"]) . "/\">" . $common->replaceHtmlSymbols($arkaWinners[0]["G_Master"]) . "</a></td>";
            if ($show2nd) {
                echo "\r\n                    <th align=\"center\">" . lang("arkawar_txt_4", true) . "</th>\r\n                    <td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($arkaWinners[1]["G_Master"]) . "/\">" . $common->replaceHtmlSymbols($arkaWinners[1]["G_Master"]) . "</a></td>";
            }
            echo "\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"center\">" . lang("arkawar_txt_5", true) . "</th>\r\n                    <td>" . $elements[$arkaWinners[0]["OuccupyObelisk"]] . "</td>";
            if ($show2nd) {
                echo "\r\n                    <th align=\"center\">" . lang("arkawar_txt_5", true) . "</th>\r\n                    <td>" . $elements[$arkaWinners[1]["OuccupyObelisk"]] . "</td>";
            }
            echo "\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"center\">" . lang("arkawar_txt_6", true) . "</th>\r\n                    <td>" . $areas[$arkaWinners[0]["ObeliskGroup"]] . "</td>";
            if ($show2nd) {
                echo "\r\n                    <th align=\"center\">" . lang("arkawar_txt_6", true) . "</th>\r\n                    <td>" . $areas[$arkaWinners[1]["ObeliskGroup"]] . "</td>";
            }
            echo "\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"center\">" . lang("arkawar_txt_7", true) . "</th>\r\n                    <td>" . date($config["date_format"], strtotime($arkaWinners[0]["WinDate"])) . "</td>";
            if ($show2nd) {
                echo "\r\n                    <th align=\"center\">" . lang("arkawar_txt_7", true) . "</th>\r\n                    <td>" . date($config["date_format"], strtotime($arkaWinners[1]["WinDate"])) . "</td>";
            }
            echo "\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </div>";
            $periodGMRegEnd = $nextBattle + mconfig("gm_reg") * 60;
            $periodGMembRegEnd = $periodGMRegEnd + mconfig("gmemb_reg") * 60;
            $periodNoticeEnd = $periodGMembRegEnd + mconfig("prog_wait") * 60;
            $periodWaitingEnd = $periodNoticeEnd + mconfig("party_wait") * 60;
            $periodBattleEnd = $periodWaitingEnd + mconfig("battle") * 60;
            $periodChannelEnd = $periodBattleEnd + mconfig("channel_close") * 60;
            $now = time();
            if ($now < $nextBattle) {
                $active1 = " style=\"color: #009900; font-weight: bold;\"";
            }
            if ($nextBattle <= $now && $now < $periodGMRegEnd) {
                $active2 = " style=\"color: #009900; font-weight: bold;\"";
            }
            if ($periodGMRegEnd <= $now && $now < $periodGMembRegEnd) {
                $active3 = " style=\"color: #009900; font-weight: bold;\"";
            }
            if ($periodGMembRegEnd <= $now && $now < $periodNoticeEnd) {
                $active4 = " style=\"color: #009900; font-weight: bold;\"";
            }
            if ($periodNoticeEnd <= $now && $now < $periodWaitingEnd) {
                $active5 = " style=\"color: #009900; font-weight: bold;\"";
            }
            if ($periodWaitingEnd <= $now && $now < $periodBattleEnd) {
                $active6 = " style=\"color: #009900; font-weight: bold;\"";
            }
            if ($periodBattleEnd <= $now && $now < $periodChannelEnd) {
                $active7 = " style=\"color: #009900; font-weight: bold;\"";
            }
            echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <thead>\r\n                <tr>\r\n                    <th colspan=\"2\">" . lang("arkawar_txt_9", true) . "</th>\r\n                </tr>\r\n            </thead>\r\n            <tbody>\r\n                <tr>\r\n                    <td width=\"50%\">" . lang("arkawar_txt_13", true) . "</td>\r\n                    <td width=\"50%\"" . $active1 . ">" . sprintf(lang("arkawar_txt_20", true), date($config["time_date_format"], $nextBattle)) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . lang("arkawar_txt_14", true) . "</td>\r\n                    <td" . $active2 . ">" . date($config["time_date_format"], $nextBattle) . " - " . date($config["time_date_format"], $periodGMRegEnd) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . lang("arkawar_txt_15", true) . "</td>\r\n                    <td" . $active3 . ">" . date($config["time_date_format"], $periodGMRegEnd) . " - " . date($config["time_date_format"], $periodGMembRegEnd) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . lang("arkawar_txt_16", true) . "</td>\r\n                    <td" . $active4 . ">" . date($config["time_date_format"], $periodGMembRegEnd) . " - " . date($config["time_date_format"], $periodNoticeEnd) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . lang("arkawar_txt_17", true) . "</td>\r\n                    <td" . $active5 . ">" . date($config["time_date_format"], $periodNoticeEnd) . " - " . date($config["time_date_format"], $periodWaitingEnd) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . lang("arkawar_txt_18", true) . "</td>\r\n                    <td" . $active6 . ">" . date($config["time_date_format"], $periodWaitingEnd) . " - " . date($config["time_date_format"], $periodBattleEnd) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . lang("arkawar_txt_19", true) . "</td>\r\n                    <td" . $active7 . ">" . date($config["time_date_format"], $periodBattleEnd) . " - " . date($config["time_date_format"], $periodChannelEnd) . "</td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </div>";
            $regGuilds = $dB->query_fetch("SELECT G_Name, MarkCnt FROM IGC_ARCA_BATTLE_GUILDMARK_REG ORDER BY MarkCnt DESC");
            echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <thead>\r\n                <tr>\r\n                    <th colspan=\"2\">" . lang("arkawar_txt_10", true) . "</th>\r\n                </tr>\r\n            </thead>\r\n            <tbody>";
            if (is_array($regGuilds)) {
                echo "\r\n                <tr>\r\n                    <th width=\"50%\">" . lang("arkawar_txt_3", true) . "</th>\r\n                    <th width=\"50%\">" . lang("arkawar_txt_11", true) . "</th>\r\n                </tr>";
                foreach ($regGuilds as $thisGuild) {
                    echo "\r\n                <tr>\r\n                    <td>" . $thisGuild["G_Name"] . "</td>\r\n                    <td>" . number_format($thisGuild["MarkCnt"]) . "</td>\r\n                </tr>";
                }
            } else {
                echo "\r\n                <tr>\r\n                    <td colspan=\"2\">" . lang("arkawar_txt_12", true) . "</td>\r\n                </tr>";
            }
            echo "\r\n            </tbody>\r\n        </table>\r\n    </div>";
            $regChars = $dB->query_fetch("SELECT G_Name, CharName FROM IGC_ARCA_BATTLE_MEMBER_JOIN_INFO ORDER BY G_Name, CharName");
            if (is_array($regChars) && $active1 == NULL) {
                $chars = [];
                foreach ($regChars as $thisChar) {
                    if (empty($chars[$thisChar["G_Name"]])) {
                        $chars[$thisChar["G_Name"]] = "<a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($thisChar["CharName"]) . "/\">" . $common->replaceHtmlSymbols($thisChar["CharName"]) . "</a>";
                    } else {
                        $easytoyou_decoder_beta_not_finish .= ", <a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($thisChar["CharName"]) . "/\">" . $common->replaceHtmlSymbols($thisChar["CharName"]) . "</a>";
                    }
                }
                echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <thead>\r\n                <tr>\r\n                    <th colspan=\"2\">" . lang("arkawar_txt_21", true) . "</th>\r\n                </tr>\r\n            </thead>\r\n            <tbody>\r\n                <tr>\r\n                    <th width=\"50%\">" . lang("arkawar_txt_3", true) . "</th>\r\n                    <th width=\"50%\">" . lang("arkawar_txt_22", true) . "</th>\r\n                </tr>";
                foreach ($chars as $gname => $chnames) {
                    echo "\r\n                <tr>\r\n                    <td><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($gname) . "/\">" . $common->replaceHtmlSymbols($gname) . "</a></td>\r\n                    <td>" . $chnames . "</td>\r\n                </tr>";
                }
                echo "\r\n            </tbody>\r\n        </table>\r\n    </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\"><h1>" . lang("arkawar_txt_1", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account-wide\" align=\"center\">";
        if (mconfig("active")) {
            $arkaWinners = $dB->query_fetch("\r\n              SELECT TOP 2 ab.G_Name as G_Name, CONVERT(date, ab.WinDate) as WinDate, ab.OuccupyObelisk as OuccupyObelisk, \r\n                ab.ObeliskGroup as ObeliskGroup, CONVERT(varchar(max), g.G_Mark, 2) as G_Mark, g.G_Master as G_Master\r\n              FROM IGC_ARCA_BATTLE_WIN_GUILD_INFO ab\r\n              INNER JOIN Guild g ON ab.G_Name = g.G_Name\r\n              ORDER BY WinDate DESC\r\n            ");
            if (is_array($arkaWinners)) {
                $battleDays = [];
                if (mconfig("monday")) {
                    array_push($battleDays, 1);
                }
                if (mconfig("tuesday")) {
                    array_push($battleDays, 2);
                }
                if (mconfig("wednesday")) {
                    array_push($battleDays, 3);
                }
                if (mconfig("thursday")) {
                    array_push($battleDays, 4);
                }
                if (mconfig("friday")) {
                    array_push($battleDays, 5);
                }
                if (mconfig("saturday")) {
                    array_push($battleDays, 6);
                }
                if (mconfig("sunday")) {
                    array_push($battleDays, 7);
                }
                $battleTimeStartHour = mconfig("event_hour");
                $battleTimeStartMinute = mconfig("event_minute");
                $elements = [1 => lang("arkawar_txt_23", true), 2 => lang("arkawar_txt_24", true), 3 => lang("arkawar_txt_25", true), 4 => lang("arkawar_txt_26", true), 5 => lang("arkawar_txt_27", true)];
                $areas = [1 => lang("arkawar_txt_28", true), 2 => lang("arkawar_txt_29", true), 3 => lang("arkawar_txt_30", true)];
                $days = ["1" => "monday", "2" => "tuesday", "3" => "wednesday", "4" => "thursday", "5" => "friday", "6" => "saturday", "7" => "sunday"];
                $nextDay = NULL;
                $currDay = date("N");
                foreach ($battleDays as $thisDay) {
                    if ($currDay < $thisDay) {
                        $nextDay = $thisDay;
                        $nextBattle = strtotime("next " . $days[$nextDay]);
                    } else {
                        if ($thisDay == $currDay) {
                            $nextDay = $currDay;
                            $nextBattle = strtotime(date("Y-m-d", time()));
                        }
                    }
                    if ($nextBattle == NULL) {
                        $nextBattle = strtotime("next " . $days[$battleDays[0]]);
                    }
                    $nextBattle += $battleTimeStartHour * 3600 + $battleTimeStartMinute * 60;
                }
            }
            if (is_array($arkaWinners[1]) && $arkaWinners[0]["WinDate"] == $arkaWinners[1]["WinDate"]) {
                $show2nd = true;
                $width1 = "15%";
                $width2 = "15%";
                $width3 = "20%";
            } else {
                $show2nd = false;
                $width1 = "33%";
                $width2 = "33%";
                $width3 = "34%";
            }
            echo "\r\n            <table class=\"irq\" width=\"100%\">\r\n                <tr>\r\n                    <th colspan=\"12\">" . lang("arkawar_txt_2", true) . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <td rowspan=\"6\" width=\"" . $width1 . "\">" . returnGuildLogo($arkaWinners[0]["G_Mark"], 112) . "</td>\r\n                    <th width=\"" . $width2 . "\">" . lang("arkawar_txt_3", true) . "</th>\r\n                    <td width=\"" . $width3 . "\"><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($arkaWinners[0]["G_Name"]) . "/\">" . $common->replaceHtmlSymbols($arkaWinners[0]["G_Name"]) . "</a></td>";
            if ($show2nd) {
                echo "\r\n                    <td rowspan=\"6\" width=\"" . $width1 . "\">" . returnGuildLogo($arkaWinners[1]["G_Mark"], 112) . "</td>\r\n                    <th width=\"" . $width2 . "\">" . lang("arkawar_txt_3", true) . "</th>\r\n                    <td width=\"" . $width3 . "\"><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($arkaWinners[1]["G_Name"]) . "/\">" . $common->replaceHtmlSymbols($arkaWinners[1]["G_Name"]) . "</a></td>";
            }
            echo "\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"center\">" . lang("arkawar_txt_4", true) . "</th>\r\n                    <td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($arkaWinners[0]["G_Master"]) . "/\">" . $common->replaceHtmlSymbols($arkaWinners[0]["G_Master"]) . "</a></td>";
            if ($show2nd) {
                echo "\r\n                    <th align=\"center\">" . lang("arkawar_txt_4", true) . "</th>\r\n                    <td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($arkaWinners[1]["G_Master"]) . "/\">" . $common->replaceHtmlSymbols($arkaWinners[1]["G_Master"]) . "</a></td>";
            }
            echo "\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"center\">" . lang("arkawar_txt_5", true) . "</th>\r\n                    <td>" . $elements[$arkaWinners[0]["OuccupyObelisk"]] . "</td>";
            if ($show2nd) {
                echo "\r\n                    <th align=\"center\">" . lang("arkawar_txt_5", true) . "</th>\r\n                    <td>" . $elements[$arkaWinners[1]["OuccupyObelisk"]] . "</td>";
            }
            echo "\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"center\">" . lang("arkawar_txt_6", true) . "</th>\r\n                    <td>" . $areas[$arkaWinners[0]["ObeliskGroup"]] . "</td>";
            if ($show2nd) {
                echo "\r\n                    <th align=\"center\">" . lang("arkawar_txt_6", true) . "</th>\r\n                    <td>" . $areas[$arkaWinners[1]["ObeliskGroup"]] . "</td>";
            }
            echo "\r\n                </tr>\r\n                <tr>\r\n                    <th align=\"center\">" . lang("arkawar_txt_7", true) . "</th>\r\n                    <td>" . date($config["date_format"], strtotime($arkaWinners[0]["WinDate"])) . "</td>";
            if ($show2nd) {
                echo "\r\n                    <th align=\"center\">" . lang("arkawar_txt_7", true) . "</th>\r\n                    <td>" . date($config["date_format"], strtotime($arkaWinners[1]["WinDate"])) . "</td>";
            }
            echo "\r\n                </tr>\r\n            </table>";
            $periodGMRegEnd = $nextBattle + mconfig("gm_reg") * 60;
            $periodGMembRegEnd = $periodGMRegEnd + mconfig("gmemb_reg") * 60;
            $periodNoticeEnd = $periodGMembRegEnd + mconfig("prog_wait") * 60;
            $periodWaitingEnd = $periodNoticeEnd + mconfig("party_wait") * 60;
            $periodBattleEnd = $periodWaitingEnd + mconfig("battle") * 60;
            $periodChannelEnd = $periodBattleEnd + mconfig("channel_close") * 60;
            $now = time();
            if ($now < $nextBattle) {
                $active1 = " style=\"color: #009900; font-weight: bold;\"";
            }
            if ($nextBattle <= $now && $now < $periodGMRegEnd) {
                $active2 = " style=\"color: #009900; font-weight: bold;\"";
            }
            if ($periodGMRegEnd <= $now && $now < $periodGMembRegEnd) {
                $active3 = " style=\"color: #009900; font-weight: bold;\"";
            }
            if ($periodGMembRegEnd <= $now && $now < $periodNoticeEnd) {
                $active4 = " style=\"color: #009900; font-weight: bold;\"";
            }
            if ($periodNoticeEnd <= $now && $now < $periodWaitingEnd) {
                $active5 = " style=\"color: #009900; font-weight: bold;\"";
            }
            if ($periodWaitingEnd <= $now && $now < $periodBattleEnd) {
                $active6 = " style=\"color: #009900; font-weight: bold;\"";
            }
            if ($periodBattleEnd <= $now && $now < $periodChannelEnd) {
                $active7 = " style=\"color: #009900; font-weight: bold;\"";
            }
            echo "\r\n            <table class=\"irq\" width=\"100%\" style=\"padding-top: 25px;\">\r\n                <tr>\r\n                    <th colspan=\"2\">" . lang("arkawar_txt_9", true) . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <td width=\"50%\">" . lang("arkawar_txt_13", true) . "</td>\r\n                    <td width=\"50%\"" . $active1 . ">" . sprintf(lang("arkawar_txt_20", true), date($config["time_date_format"], $nextBattle)) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . lang("arkawar_txt_14", true) . "</td>\r\n                    <td" . $active2 . ">" . date($config["time_date_format"], $nextBattle) . " - " . date($config["time_date_format"], $periodGMRegEnd) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . lang("arkawar_txt_15", true) . "</td>\r\n                    <td" . $active3 . ">" . date($config["time_date_format"], $periodGMRegEnd) . " - " . date($config["time_date_format"], $periodGMembRegEnd) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . lang("arkawar_txt_16", true) . "</td>\r\n                    <td" . $active4 . ">" . date($config["time_date_format"], $periodGMembRegEnd) . " - " . date($config["time_date_format"], $periodNoticeEnd) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . lang("arkawar_txt_17", true) . "</td>\r\n                    <td" . $active5 . ">" . date($config["time_date_format"], $periodNoticeEnd) . " - " . date($config["time_date_format"], $periodWaitingEnd) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . lang("arkawar_txt_18", true) . "</td>\r\n                    <td" . $active6 . ">" . date($config["time_date_format"], $periodWaitingEnd) . " - " . date($config["time_date_format"], $periodBattleEnd) . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . lang("arkawar_txt_19", true) . "</td>\r\n                    <td" . $active7 . ">" . date($config["time_date_format"], $periodBattleEnd) . " - " . date($config["time_date_format"], $periodChannelEnd) . "</td>\r\n                </tr>\r\n            </table>";
            $regGuilds = $dB->query_fetch("SELECT G_Name, MarkCnt FROM IGC_ARCA_BATTLE_GUILDMARK_REG ORDER BY MarkCnt DESC");
            echo "\r\n            <table class=\"irq\" width=\"100%\" style=\"padding-top: 25px;\">\r\n                <tr>\r\n                    <th colspan=\"2\">" . lang("arkawar_txt_10", true) . "</th>\r\n                </tr>";
            if (is_array($regGuilds)) {
                echo "\r\n                <tr>\r\n                    <th width=\"50%\">" . lang("arkawar_txt_3", true) . "</th>\r\n                    <th width=\"50%\">" . lang("arkawar_txt_11", true) . "</th>\r\n                </tr>";
                foreach ($regGuilds as $thisGuild) {
                    echo "\r\n                <tr>\r\n                    <td>" . $thisGuild["G_Name"] . "</td>\r\n                    <td>" . number_format($thisGuild["MarkCnt"]) . "</td>\r\n                </tr>";
                }
            } else {
                echo "\r\n                <tr>\r\n                    <td colspan=\"2\">" . lang("arkawar_txt_12", true) . "</td>\r\n                </tr>";
            }
            echo "\r\n            </table>";
            $regChars = $dB->query_fetch("SELECT G_Name, CharName FROM IGC_ARCA_BATTLE_MEMBER_JOIN_INFO ORDER BY G_Name, CharName");
            if (is_array($regChars) && $active1 == NULL) {
                $chars = [];
                foreach ($regChars as $thisChar) {
                    if (empty($chars[$thisChar["G_Name"]])) {
                        $chars[$thisChar["G_Name"]] = "<a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($thisChar["CharName"]) . "/\">" . $common->replaceHtmlSymbols($thisChar["CharName"]) . "</a>";
                    } else {
                        $easytoyou_decoder_beta_not_finish .= ", <a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($thisChar["CharName"]) . "/\">" . $common->replaceHtmlSymbols($thisChar["CharName"]) . "</a>";
                    }
                }
                echo "\r\n            <table class=\"irq\" width=\"100%\" style=\"padding-top: 25px;\">\r\n                <tr>\r\n                    <th colspan=\"2\">" . lang("arkawar_txt_21", true) . "</th>\r\n                </tr>\r\n                <tr>\r\n                    <th width=\"50%\">" . lang("arkawar_txt_3", true) . "</th>\r\n                    <th width=\"50%\">" . lang("arkawar_txt_22", true) . "</th>\r\n                </tr>";
                foreach ($chars as $gname => $chnames) {
                    echo "\r\n                <tr>\r\n                    <td><a href=\"" . __BASE_URL__ . "profile/guild/req/" . hex_encode($gname) . "/\">" . $common->replaceHtmlSymbols($gname) . "</a></td>\r\n                    <td>" . $chnames . "</td>\r\n                </tr>";
                }
                echo "\r\n            </table>";
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n        </div>\r\n    </div>\r\n</div>";
    }
}

?>