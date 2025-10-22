<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$Rankings = new Rankings();
loadModuleConfigs("rankings");
if (mconfig("active")) {
    $currTime = time();
    $currDay = date("j", $currTime);
    $currWeekDay = date("N", $currTime);
    $today = date("Y-m-d 00:00:00", $currTime);
    $periodStartDaily = date("Y-m-d", strtotime("-1 days"));
    $periodEndDaily = date("Y-m-d", strtotime("-1 days"));
    $monsterHunterCfg = loadConfigurations("monster_hunter");
    $checkRewardLog = $dB->query_fetch_single("SELECT TOP 1 Date FROM IMPERIAMUCMS_RANKINGS_REWARDS_LOGS WHERE Period_Type = 'daily' ORDER BY Date DESC");
    if ($checkRewardLog["Date"] < $today || $checkRewardLog["Date"] == NULL) {
        if (mconfig("rewards_characters")["@attributes"]["daily"]) {
            $Rankings->giveRankingsRewards("characters", "daily", $periodStartDaily, $periodEndDaily);
        }
        if (mconfig("rewards_guilds")["@attributes"]["daily"]) {
            $Rankings->giveRankingsRewards("guilds", "daily", $periodStartDaily, $periodEndDaily);
        }
        if (mconfig("rewards_level")["@attributes"]["daily"]) {
            $Rankings->giveRankingsRewards("level", "daily", $periodStartDaily, $periodEndDaily);
        }
        if (mconfig("rewards_master")["@attributes"]["daily"]) {
            $Rankings->giveRankingsRewards("master", "daily", $periodStartDaily, $periodEndDaily);
        }
        if (mconfig("rewards_resets")["@attributes"]["daily"]) {
            $Rankings->giveRankingsRewards("resets", "daily", $periodStartDaily, $periodEndDaily);
        }
        if (mconfig("rewards_grandresets")["@attributes"]["daily"]) {
            $Rankings->giveRankingsRewards("grandresets", "daily", $periodStartDaily, $periodEndDaily);
        }
        if (mconfig("rewards_killers")["@attributes"]["daily"]) {
            $Rankings->giveRankingsRewards("killers", "daily", $periodStartDaily, $periodEndDaily);
        }
        if (mconfig("rewards_duels")["@attributes"]["daily"]) {
            $Rankings->giveRankingsRewards("duels", "daily", $periodStartDaily, $periodEndDaily);
        }
        if (mconfig("rewards_bc")["@attributes"]["daily"]) {
            $Rankings->giveRankingsRewards("bloodcastle", "daily", $periodStartDaily, $periodEndDaily);
        }
        if (mconfig("rewards_ds")["@attributes"]["daily"]) {
            $Rankings->giveRankingsRewards("devilsquare", "daily", $periodStartDaily, $periodEndDaily);
        }
        if (mconfig("rewards_cc")["@attributes"]["daily"]) {
            $Rankings->giveRankingsRewards("chaoscastle", "daily", $periodStartDaily, $periodEndDaily);
        }
        if (mconfig("rewards_it")["@attributes"]["daily"]) {
            $Rankings->giveRankingsRewards("illusiontemple", "daily", $periodStartDaily, $periodEndDaily);
        }
        foreach ($monsterHunterCfg["Monster"] as $thisMonster) {
            if ($thisMonster["@attributes"]["daily_reward"] == "1") {
                $monsterId = $thisMonster["@attributes"]["id"];
                if ($monsterId == "-1") {
                    $monsterId = "all";
                }
                $Rankings->giveRankingsRewards("monster_hunter", "daily", $periodStartDaily, $periodEndDaily, $monsterId);
            }
        }
    }
    if (mconfig("rankings_week_start") == "sunday") {
        $startDay = "sunday";
        $startWeekDay = 7;
        $endDay = "monday";
    } else {
        $startDay = "monday";
        $startWeekDay = 1;
        $endDay = "sunday";
    }
    if (date("N", $currTime) == $startWeekDay) {
        $periodStartWeekly = date("Y-m-d", strtotime("last " . $startDay));
        $periodEndWeekly = date("Y-m-d", strtotime("last " . $endDay));
        $checkRewardLog = $dB->query_fetch_single("SELECT TOP 1 Date FROM IMPERIAMUCMS_RANKINGS_REWARDS_LOGS WHERE Period_Type = 'weekly' ORDER BY Date DESC");
        if ($checkRewardLog["Date"] < $today || $checkRewardLog["Date"] == NULL) {
            if (mconfig("rewards_characters")["@attributes"]["weekly"]) {
                $Rankings->giveRankingsRewards("characters", "weekly", $periodStartWeekly, $periodEndWeekly);
            }
            if (mconfig("rewards_guilds")["@attributes"]["weekly"]) {
                $Rankings->giveRankingsRewards("guilds", "weekly", $periodStartWeekly, $periodEndWeekly);
            }
            if (mconfig("rewards_level")["@attributes"]["weekly"]) {
                $Rankings->giveRankingsRewards("level", "weekly", $periodStartWeekly, $periodEndWeekly);
            }
            if (mconfig("rewards_master")["@attributes"]["weekly"]) {
                $Rankings->giveRankingsRewards("master", "weekly", $periodStartWeekly, $periodEndWeekly);
            }
            if (mconfig("rewards_resets")["@attributes"]["weekly"]) {
                $Rankings->giveRankingsRewards("resets", "weekly", $periodStartWeekly, $periodEndWeekly);
            }
            if (mconfig("rewards_grandresets")["@attributes"]["weekly"]) {
                $Rankings->giveRankingsRewards("grandresets", "weekly", $periodStartWeekly, $periodEndWeekly);
            }
            if (mconfig("rewards_killers")["@attributes"]["weekly"]) {
                $Rankings->giveRankingsRewards("killers", "weekly", $periodStartWeekly, $periodEndWeekly);
            }
            if (mconfig("rewards_duels")["@attributes"]["weekly"]) {
                $Rankings->giveRankingsRewards("duels", "weekly", $periodStartWeekly, $periodEndWeekly);
            }
            if (mconfig("rewards_bc")["@attributes"]["weekly"]) {
                $Rankings->giveRankingsRewards("bloodcastle", "weekly", $periodStartWeekly, $periodEndWeekly);
            }
            if (mconfig("rewards_ds")["@attributes"]["weekly"]) {
                $Rankings->giveRankingsRewards("devilsquare", "weekly", $periodStartWeekly, $periodEndWeekly);
            }
            if (mconfig("rewards_cc")["@attributes"]["weekly"]) {
                $Rankings->giveRankingsRewards("chaoscastle", "weekly", $periodStartWeekly, $periodEndWeekly);
            }
            if (mconfig("rewards_it")["@attributes"]["weekly"]) {
                $Rankings->giveRankingsRewards("illusiontemple", "weekly", $periodStartWeekly, $periodEndWeekly);
            }
            foreach ($monsterHunterCfg["Monster"] as $thisMonster) {
                if ($thisMonster["@attributes"]["weekly_reward"] == "1") {
                    $monsterId = $thisMonster["@attributes"]["id"];
                    if ($monsterId == "-1") {
                        $monsterId = "all";
                    }
                    $Rankings->giveRankingsRewards("monster_hunter", "weekly", $periodStartWeekly, $periodEndWeekly, $monsterId);
                }
            }
        }
    }
    if ($currDay == "1") {
        $periodStartMonthly = date("Y-m-d", strtotime("first day of last month"));
        $periodEndMonthly = date("Y-m-d", strtotime("last day of last month"));
        $checkRewardLog = $dB->query_fetch_single("SELECT TOP 1 Date FROM IMPERIAMUCMS_RANKINGS_REWARDS_LOGS WHERE Period_Type = 'monthly' ORDER BY Date DESC");
        if ($checkRewardLog["Date"] < $today || $checkRewardLog["Date"] == NULL) {
            if (mconfig("rewards_characters")["@attributes"]["monthly"]) {
                $Rankings->giveRankingsRewards("characters", "monthly", $periodStartMonthly, $periodEndMonthly);
            }
            if (mconfig("rewards_guilds")["@attributes"]["monthly"]) {
                $Rankings->giveRankingsRewards("guilds", "monthly", $periodStartMonthly, $periodEndMonthly);
            }
            if (mconfig("rewards_votes")["@attributes"]["monthly"]) {
                $Rankings->giveRankingsRewards("votes", "monthly", $periodStartMonthly, $periodEndMonthly);
            }
            if (mconfig("rewards_level")["@attributes"]["monthly"]) {
                $Rankings->giveRankingsRewards("level", "monthly", $periodStartMonthly, $periodEndMonthly);
            }
            if (mconfig("rewards_master")["@attributes"]["monthly"]) {
                $Rankings->giveRankingsRewards("master", "monthly", $periodStartMonthly, $periodEndMonthly);
            }
            if (mconfig("rewards_resets")["@attributes"]["monthly"]) {
                $Rankings->giveRankingsRewards("resets", "monthly", $periodStartMonthly, $periodEndMonthly);
            }
            if (mconfig("rewards_grandresets")["@attributes"]["monthly"]) {
                $Rankings->giveRankingsRewards("grandresets", "monthly", $periodStartMonthly, $periodEndMonthly);
            }
            if (mconfig("rewards_killers")["@attributes"]["monthly"]) {
                $Rankings->giveRankingsRewards("killers", "monthly", $periodStartMonthly, $periodEndMonthly);
            }
            if (mconfig("rewards_duels")["@attributes"]["monthly"]) {
                $Rankings->giveRankingsRewards("duels", "monthly", $periodStartMonthly, $periodEndMonthly);
            }
            if (mconfig("rewards_votes")["@attributes"]["monthly"]) {
                $Rankings->giveRankingsRewards("votes", "monthly", $periodStartMonthly, $periodEndMonthly);
            }
            if (mconfig("rewards_bc")["@attributes"]["monthly"]) {
                $Rankings->giveRankingsRewards("bloodcastle", "monthly", $periodStartMonthly, $periodEndMonthly);
            }
            if (mconfig("rewards_ds")["@attributes"]["monthly"]) {
                $Rankings->giveRankingsRewards("devilsquare", "monthly", $periodStartMonthly, $periodEndMonthly);
            }
            if (mconfig("rewards_cc")["@attributes"]["monthly"]) {
                $Rankings->giveRankingsRewards("chaoscastle", "monthly", $periodStartMonthly, $periodEndMonthly);
            }
            if (mconfig("rewards_it")["@attributes"]["monthly"]) {
                $Rankings->giveRankingsRewards("illusiontemple", "monthly", $periodStartMonthly, $periodEndMonthly);
            }
            foreach ($monsterHunterCfg["Monster"] as $thisMonster) {
                if ($thisMonster["@attributes"]["monthly_reward"] == "1") {
                    $monsterId = $thisMonster["@attributes"]["id"];
                    if ($monsterId == "-1") {
                        $monsterId = "all";
                    }
                    $Rankings->giveRankingsRewards("monster_hunter", "monthly", $periodStartMonthly, $periodEndMonthly, $monsterId);
                }
            }
        }
    }
}
updateCronLastRun($file_name);

?>