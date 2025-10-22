<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
loadModuleConfigs("usercp.architect");
$now = time();
$currWeekday = date("N", $now);
if ($currWeekday == mconfig("reward_day")) {
    $lastRun = NULL;
    $architectCache = LoadCacheData("architect_rewards.cache");
    $i = 0;
    foreach ($architectCache as $thisData) {
        if ($i == 1) {
            $lastRun = $thisData[0];
            if ($lastRun < date("Y-m-d", $now) || $lastRun == NULL || $lastRun == "") {
                $Architect = new Architect();
                $castleOwnerData = $Architect->castleOwnerData();
                $buildingsData = $Architect->loadBuildingsData($castleOwnerData["G_Name"]);
                if (mconfig("building_mine") && 1 <= $buildingsData["Mine_Level"]) {
                    $currLevelCfg = mconfig("mine_stage" . $buildingsData["Mine_Level"]);
                    $bless = rand($currLevelCfg["reward_bless_min"], $currLevelCfg["reward_bless_max"]);
                    $soul = rand($currLevelCfg["reward_soul_min"], $currLevelCfg["reward_soul_max"]);
                    $life = rand($currLevelCfg["reward_life_min"], $currLevelCfg["reward_life_max"]);
                    $chaos = rand($currLevelCfg["reward_chaos_min"], $currLevelCfg["reward_chaos_max"]);
                    $harmony = rand($currLevelCfg["reward_harmony_min"], $currLevelCfg["reward_harmony_max"]);
                    $creation = rand($currLevelCfg["reward_creation_min"], $currLevelCfg["reward_creation_max"]);
                    $guardian = rand($currLevelCfg["reward_guardian_min"], $currLevelCfg["reward_guardian_max"]);
                    $insert = $dB->query("INSERT INTO IMPERIAMUCMS_ARCHITECT_MINE (Guild, Date, bless, soul, life, chaos, harmony, creation, guardian) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [$castleOwnerData["G_Name"], date("Y-m-d H:i:s", $now), $bless, $soul, $life, $chaos, $harmony, $creation, $guardian]);
                    $update = $dB->query("UPDATE IMPERIAMUCMS_WEB_BANK_GUILD SET bless = bless + ?, soul = soul + ?, life = life + ?, chaos = chaos + ?, harmony = harmony + ?, \r\n                creation = creation + ?, guardian = guardian + ? WHERE Guild = ?", [$bless, $soul, $life, $chaos, $harmony, $creation, $guardian, $castleOwnerData["G_Name"]]);
                }
                if (mconfig("building_bank") && 1 <= $buildingsData["Bank_Level"]) {
                    $currLevelCfg = mconfig("bank_stage" . $buildingsData["Bank_Level"]);
                    $investments = $Architect->loadAllInvestments();
                    if ($investments != NULL) {
                        foreach ($investments as $thisInvestment) {
                            $platinum = (100 + $currLevelCfg["reward_platinum"]) * $thisInvestment["platinum"] / 100;
                            $gold = (100 + $currLevelCfg["reward_gold"]) * $thisInvestment["gold"] / 100;
                            $silver = (100 + $currLevelCfg["reward_silver"]) * $thisInvestment["silver"] / 100;
                            $wcoin = (100 + $currLevelCfg["reward_wcoin"]) * $thisInvestment["wcoin"] / 100;
                            $gp = (100 + $currLevelCfg["reward_gp"]) * $thisInvestment["gp"] / 100;
                            $zen = (100 + $currLevelCfg["reward_zen"]) * $thisInvestment["zen"] / 100;
                            $update = $dB->query("UPDATE IMPERIAMUCMS_ARCHITECT_BANK SET platinum = ?, gold = ?, silver = ?, wcoin = ?, gp = ?, zen = ? WHERE Guild = ? AND AccountID = ? AND Name = ?", [$platinum, $gold, $silver, $wcoin, $gp, $zen, $castleOwnerData["G_Name"], $thisInvestment["AccountID"], $thisInvestment["Name"]]);
                        }
                    }
                }
                $lastReward = [];
                $lastReward[0] = [date("Y-m-d", $now)];
                $cacheDATA = BuildCacheData($lastReward);
                UpdateCache("architect_rewards.cache", $cacheDATA);
            }
        } else {
            $i++;
        }
    }
}
updateCronLastRun($file_name);

?>