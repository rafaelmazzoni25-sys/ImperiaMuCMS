<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Rankings
{
    public function UpdateRankingCache($ranking_type)
    {
        global $config;
        global $custom;
        global $dB;
        global $dB2;
        loadModuleConfigs("rankings");
        if (config("SQL_USE_2_DB", true)) {
            $memb_info = "[" . $config["SQL_DB_2_NAME"] . "].[dbo].[MEMB_INFO]";
            $memb_stat = "[" . $config["SQL_DB_2_NAME"] . "].[dbo].[MEMB_STAT]";
        } else {
            $memb_info = "[" . $config["SQL_DB_NAME"] . "].[dbo].[MEMB_INFO]";
            $memb_stat = "[" . $config["SQL_DB_NAME"] . "].[dbo].[MEMB_STAT]";
        }
        $order1 = mconfig("order_priority_1");
        $order2 = mconfig("order_priority_2");
        $order3 = mconfig("order_priority_3");
        $order4 = mconfig("order_priority_4");
        $dayToCheck = date("Y-m-d H:i:s", time() - 86400 * mconfig("rankings_active_days"));
        if (mconfig("rankings_only_active") == "1") {
            $showOnlyActive = "AND ms.ConnectTM > '" . $dayToCheck . "'";
        } else {
            $showOnlyActive = "";
        }
        switch ($ranking_type) {
            case "characters":
                $includeHonor = "";
                if (mconfig("include_honor_on_char_rankings") == "0") {
                    if (0 < mconfig("honor_level")) {
                        $includeHonor .= " AND c.cLevel < " . mconfig("honor_level");
                    }
                    if (0 < mconfig("honor_mlevel")) {
                        $includeHonor .= " AND c.mLevel < " . mconfig("honor_mlevel");
                    }
                    if (0 < mconfig("honor_reset")) {
                        $includeHonor .= " AND c.RESETS < " . mconfig("honor_reset");
                    }
                    if (0 < mconfig("honor_greset")) {
                        $includeHonor .= " AND c.Grand_Resets < " . mconfig("honor_greset");
                    }
                }
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 " . $includeHonor . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_characters.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["wizard"]) . ") " . $includeHonor . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_characters_wizard.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["knight"]) . ") " . $includeHonor . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_characters_knight.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["elf"]) . ") " . $includeHonor . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_characters_elf.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["gladiator"]) . ") " . $includeHonor . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_characters_gladiator.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["lord"]) . ") " . $includeHonor . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_characters_lord.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["summoner"]) . ") " . $includeHonor . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_characters_summoner.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["fighter"]) . ") " . $includeHonor . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_characters_fighter.cache", $cacheDATA);
                if (100 <= config("server_files_season", true)) {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                    INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                    INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["lancer"]) . ") " . $includeHonor . " " . $showOnlyActive . "\r\n                    ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                    $cacheDATA = BuildCacheData($dbDATA);
                    UpdateCache("rankings_characters_lancer.cache", $cacheDATA);
                }
                if (140 <= config("server_files_season", true)) {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                    INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                    INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["rune"]) . ") " . $includeHonor . " " . $showOnlyActive . "\r\n                    ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                    $cacheDATA = BuildCacheData($dbDATA);
                    UpdateCache("rankings_characters_rune.cache", $cacheDATA);
                }
                if (150 <= config("server_files_season", true)) {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                    INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                    INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["slayer"]) . ") " . $includeHonor . " " . $showOnlyActive . "\r\n                    ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                    $cacheDATA = BuildCacheData($dbDATA);
                    UpdateCache("rankings_characters_slayer.cache", $cacheDATA);
                }
                break;
            case "level":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.cLevel,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID\r\n                WHERE Name NOT IN(" . rankingsExcludeChars() . ") AND CtlCode = 0 ORDER BY c.cLevel DESC, c.Grand_Resets DESC, c.RESETS DESC, c.mLevel DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_level.cache", $cacheDATA);
                break;
            case "master":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.mLevel,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID\r\n                WHERE Name NOT IN(" . rankingsExcludeChars() . ") AND CtlCode = 0 ORDER BY c.mLevel DESC, c.Grand_Resets DESC, c.RESETS DESC, c.clevel DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_master.cache", $cacheDATA);
                break;
            case "resets":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.RESETS,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID\r\n                WHERE Name NOT IN(" . rankingsExcludeChars() . ") AND CtlCode = 0 ORDER BY c.RESETS DESC, c.Grand_Resets DESC, c.mLevel DESC, c.cLevel DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_resets.cache", $cacheDATA);
                break;
            case "grandresets":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID\r\n                WHERE Name NOT IN(" . rankingsExcludeChars() . ") AND CtlCode = 0 ORDER BY c.Grand_Resets DESC, c.RESETS DESC, c.mLevel DESC, c.cLevel DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_gr.cache", $cacheDATA);
                break;
            case "killers":
                if (mconfig("rankings_killers_type")) {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name, c.Class, COUNT(pk.Killer) as count, m.Country FROM C_PlayerKiller_Info pk\r\n                                                INNER JOIN Character c ON c.Name = pk.Killer\r\n                                                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID\r\n                                                GROUP BY pk.Killer, c.Name, c.Class, m.Country ORDER BY count DESC");
                } else {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.PkCount,m.Country FROM Character c\r\n                                                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID\r\n                                                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 ORDER BY c.PkCount DESC");
                }
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_pk.cache", $cacheDATA);
                break;
            case "online":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " m.memb___id,m.OnlineTime,i.Country,c.Name,c.Class FROM " . $memb_stat . " m\r\n                CROSS APPLY (\r\n                    SELECT TOP 1 Name, Class, CtlCode\r\n                    FROM Character WHERE AccountId = m.memb___id \r\n                    ORDER BY Grand_Resets DESC, RESETS DESC, mLevel DESC, cLevel DESC\r\n                ) c\r\n                INNER JOIN " . $memb_info . " i ON i.memb___id = m.memb___id\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0\r\n                ORDER BY m.OnlineTime DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_online.cache", $cacheDATA);
                break;
            case "votes":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " user_id,COUNT(*) as count,\r\n                                                SUM(CAST(timestamp as bigint) - 1500000000) as totalTime,\r\n                                                (SELECT TOP 1 Country FROM " . $memb_info . " WHERE memb_guid = user_id) as Country\r\n                                                FROM IMPERIAMUCMS_VOTES\r\n                                                WHERE confirm = 1 GROUP BY user_id ORDER BY count DESC, totalTime ASC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_votes.cache", $cacheDATA);
                break;
            case "guilds":
                if (mconfig("rankings_guild_type")) {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " G_Name, G_Master,\r\n                                                (SELECT SUM(cLevel) FROM Character\r\n                                                    INNER JOIN GuildMember ON Character.Name = GuildMember.Name\r\n                                                    WHERE GuildMember.G_Name = Guild.G_Name\r\n                                                ) AS cLevel,\r\n                                                (SELECT SUM(mLevel) FROM Character\r\n                                                    INNER JOIN GuildMember ON Character.Name = GuildMember.Name\r\n                                                    WHERE GuildMember.G_Name = Guild.G_Name\r\n                                                ) AS mLevel,\r\n                                                (SELECT SUM(RESETS) FROM Character\r\n                                                    INNER JOIN GuildMember ON Character.Name = GuildMember.Name\r\n                                                    WHERE GuildMember.G_Name = Guild.G_Name\r\n                                                ) AS RESETS,\r\n                                                (SELECT SUM(Grand_Resets) FROM Character\r\n                                                    INNER JOIN GuildMember ON Character.Name = GuildMember.Name\r\n                                                    WHERE GuildMember.G_Name = Guild.G_Name\r\n                                                ) AS Grand_Resets, \r\n                                                CONVERT(varchar(max), G_Mark, 2) as G_Mark,\r\n                                                (SELECT COUNT(*) FROM GuildMember WHERE G_Name = Guild.G_Name) as TotalMembers, G_Score\r\n                                                FROM Guild \r\n                                                ORDER BY " . $order1 . " DESC, " . $order2 . " DESC, " . $order3 . " DESC, " . $order4 . " DESC, G_Score DESC");
                } else {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " G_Name, G_Master,\r\n                                                (SELECT SUM(cLevel) FROM Character\r\n                                                    INNER JOIN GuildMember ON Character.Name = GuildMember.Name\r\n                                                    WHERE GuildMember.G_Name = Guild.G_Name\r\n                                                ) AS TotalLevel,\r\n                                                (SELECT SUM(mLevel) FROM Character\r\n                                                    INNER JOIN GuildMember ON Character.Name = GuildMember.Name\r\n                                                    WHERE GuildMember.G_Name = Guild.G_Name\r\n                                                ) AS TotalMasterLevel,\r\n                                                (SELECT SUM(RESETS) FROM Character\r\n                                                    INNER JOIN GuildMember ON Character.Name = GuildMember.Name\r\n                                                    WHERE GuildMember.G_Name = Guild.G_Name\r\n                                                ) AS TotalReset,\r\n                                                (SELECT SUM(Grand_Resets) FROM Character\r\n                                                    INNER JOIN GuildMember ON Character.Name = GuildMember.Name\r\n                                                    WHERE GuildMember.G_Name = Guild.G_Name\r\n                                                ) AS TotalGrandReset, \r\n                                                CONVERT(varchar(max), G_Mark, 2) as G_Mark,\r\n                                                (SELECT COUNT(*) FROM GuildMember WHERE G_Name = Guild.G_Name) as TotalMembers, G_Score\r\n                                                FROM Guild \r\n                                                ORDER BY G_Score DESC");
                }
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_guilds.cache", $cacheDATA);
                break;
            case "pvplaststand":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " " . _CLMN_CHR_NAME_ . ", " . _CLMN_CHR_CLASS_ . ", " . _CLMN_CHR_PVPLS_WIN_ . " FROM " . _TBL_CHR_ . " ORDER BY " . _CLMN_CHR_PVPLS_WIN_ . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_pvplaststand.cache", $cacheDATA);
                break;
            case "gens":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " g.Name,g.Class as GClass,g.Influence,g.Rank,g.Points,c.Class as CClass,m.Country FROM IGC_Gens g\r\n                                            INNER JOIN Character c on c.Name = g.Name INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID WHERE g.Points > 0 AND c.CtlCode = 0 ORDER BY g.Points DESC, g.Rank ASC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_gens.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " g.Name,g.Class as GClass,g.Influence,g.Rank,g.Points,c.Class as CClass,m.Country FROM IGC_Gens g\r\n                                            INNER JOIN Character c on c.Name = g.Name INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID WHERE g.Points > 0 AND g.Influence = 1 AND c.CtlCode = 0 ORDER BY g.Points DESC, g.Rank ASC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_gens_duprian.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " g.Name,g.Class as GClass,g.Influence,g.Rank,g.Points,c.Class as CClass,m.Country FROM IGC_Gens g\r\n                                            INNER JOIN Character c on c.Name = g.Name INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID WHERE g.Points > 0 AND g.Influence = 2 AND c.CtlCode = 0 ORDER BY g.Points DESC, g.Rank ASC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_gens_vanert.cache", $cacheDATA);
                break;
            case "duels":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,c.WinDuels,c.LoseDuels,m.Country FROM Character c\r\n                                            INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID\r\n                                            WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.WinDuels > 0 ORDER BY c.WinDuels DESC, c.LoseDuels ASC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_duels.cache", $cacheDATA);
                break;
            case "devilsquare":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " e.CharacterName,c.Class,SUM(e.Point) as Point,m.Country FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO] e\r\n                                            LEFT JOIN Character c ON c.Name = e.CharacterName\r\n                                            LEFT JOIN " . $memb_info . " m ON m.memb___id = e.AccountID\r\n                                            WHERE e.CharacterName NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND Point > 0 GROUP BY e.CharacterName,c.Class,m.Country ORDER BY Point DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_devilsquare.cache", $cacheDATA);
                break;
            case "bloodcastle":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " e.CharacterName,c.Class,SUM(e.Point) as Point,SUM(e.PlayCount),m.Country FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_BC_5TH] e\r\n                                            LEFT JOIN Character c ON c.Name = e.CharacterName\r\n                                            LEFT JOIN " . $memb_info . " m ON m.memb___id = e.AccountID\r\n                                            WHERE e.CharacterName NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND Point > 0 GROUP BY e.CharacterName,c.Class,m.Country ORDER BY Point DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_bloodcastle.cache", $cacheDATA);
                break;
            case "chaoscastle":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " e.Name,c.Class,SUM(e.PKillCount) as PKillCount,SUM(e.MKillCount) as MKillCount,SUM(e.Wins) as Wins,m.Country FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_CC] e\r\n                                            LEFT JOIN Character c ON c.Name = e.Name\r\n                                            LEFT JOIN " . $memb_info . " m ON m.memb___id = e.AccountID\r\n                                            WHERE e.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND MKillCount > 0 GROUP BY e.Name,c.Class,m.Country ORDER BY Wins DESC, PKillCount DESC, MKillCount DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_chaoscastle.cache", $cacheDATA);
                break;
            case "illusiontemple":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " e.Name,c.Class,SUM(e.TotalScore) as TotalScore,SUM(e.KillCount) as KillCount,SUM(e.PlayCount) as PlayCount,m.Country,SUM(isWinner) as Wins,SUM(RelicsGivenCount) as RelicsGiven FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_IT] e\r\n                                            LEFT JOIN Character c ON c.Name = e.Name\r\n                                            LEFT JOIN " . $memb_info . " m ON m.memb___id = e.AccountID\r\n                                            WHERE e.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND TotalScore > 0 GROUP BY e.Name,c.Class,m.Country ORDER BY TotalScore DESC, Wins DESC, RelicsGiven DESC, KillCount DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_illusiontemple.cache", $cacheDATA);
                break;
            case "cshistory":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.SIEGE_START_DATE,c.SIEGE_END_DATE,c.OWNER_GUILD,c.GUILD_MASTER,CONVERT(varchar(max), g.G_Mark, 2) as G_Mark,m.Country FROM IMPERIAMUCMS_CS_HISTORY c\r\n                                            INNER JOIN Guild g on g.G_Name = c.OWNER_GUILD\r\n                                            INNER JOIN Character a on a.Name = c.GUILD_MASTER\r\n                                            INNER JOIN " . $memb_info . " m ON m.memb___id = a.AccountID\r\n                                            ORDER BY c.SIEGE_END_DATE DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_cshistory.cache", $cacheDATA);
                break;
            case "arkawar_history":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " aw.G_Name, CONVERT(varchar(max), aw.G_Mark, 2) as G_Mark, aw.G_Master, aw.WinDate, aw.OuccupyObelisk, aw.ObeliskGroup, m.Country FROM IMPERIAMUCMS_ARKAWAR_HISTORY aw\r\n                                            INNER JOIN Character a on a.Name = aw.G_Master\r\n                                            INNER JOIN " . $memb_info . " m ON m.memb___id = a.AccountID\r\n                                            ORDER BY aw.WinDate DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_arkawar_history.cache", $cacheDATA);
                break;
            case "icewindvalley_history":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " iw.G_Name, CONVERT(varchar(max), iw.G_Mark, 2) as G_Mark, iw.G_Master, iw.WinDate, m.Country \r\n                                            FROM IMPERIAMUCMS_IWV_HISTORY iw\r\n                                            INNER JOIN Character a on a.Name = iw.G_Master\r\n                                            INNER JOIN " . $memb_info . " m ON m.memb___id = a.AccountID\r\n                                            ORDER BY iw.WinDate DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_icewindvalley_history.cache", $cacheDATA);
                break;
            case "achievements":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name,c.Class,a.Completed,a.Points,m.Country FROM IMPERIAMUCMS_ACHIEVEMENTS_RANKING a\r\n                                            INNER JOIN Character c ON c.Name = a.Name\r\n                                            INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID\r\n                                            WHERE a.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND a.Points > 0 ORDER BY a.Points DESC, a.Completed DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_achievements.cache", $cacheDATA);
                break;
            case "online_players":
                if ($config["SQL_USE_2_DB"] && $config["server_names"] != NULL && !empty($config["server_names"])) {
                    $server_names = "";
                    foreach ($config["server_names"] as $thisName) {
                        if ($server_names == "") {
                            $server_names = "'" . $thisName . "'";
                        } else {
                            $server_names .= ", '" . $thisName . "'";
                        }
                    }
                    $dbDATA = $dB->query_fetch("SELECT c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country,ms.ConnectStat,c.MapNumber,ms.ServerName FROM " . $memb_stat . " ms\r\n                                                INNER JOIN " . $memb_info . " m ON m.memb___id = ms.memb___id\r\n                                                INNER JOIN Character c ON c.AccountID = ms.memb___id\r\n                                                WHERE c.Name = (SELECT TOP 1 GameIDC FROM AccountCharacter WHERE Id = ms.memb___id) AND ms.ConnectStat = '1' AND ms.ServerName IN (" . $server_names . ")\r\n                                                ORDER BY ms.ConnectTM");
                } else {
                    $dbDATA = $dB->query_fetch("SELECT c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country,ms.ConnectStat,c.MapNumber,ms.ServerName FROM " . $memb_stat . " ms\r\n                                                INNER JOIN " . $memb_info . " m ON m.memb___id = ms.memb___id\r\n                                                INNER JOIN Character c ON c.AccountID = ms.memb___id\r\n                                                WHERE c.Name = (SELECT TOP 1 GameIDC FROM AccountCharacter WHERE Id = ms.memb___id) AND ms.ConnectStat = '1'\r\n                                                ORDER BY ms.ConnectTM");
                }
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_online_players.cache", $cacheDATA);
                break;
            case "mulords":
                $ranks = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_MU_LORDS_RANKS");
                $guildsOrdered = [];
                $guilds = $dB->query_fetch("SELECT G_Name, G_Master, CONVERT(varchar(max), G_Mark, 2) as G_Mark FROM Guild");
                $i = 0;
                foreach ($guilds as $thisGuild) {
                    $members = $dB->query_fetch("SELECT * FROM GuildMember WHERE G_Name = ?", [$thisGuild["G_Name"]]);
                    $total_donation = 0;
                    $total_level = 0;
                    $total_coins = 0;
                    foreach ($members as $thisMember) {
                        $AccountID = $dB->query_fetch_single("SELECT AccountID, cLevel, mLevel FROM Character WHERE Name = ?", [$thisMember["Name"]]);
                        $donations = $dB->query_fetch_single("SELECT SUM(amount) as sum FROM IMPERIAMUCMS_MU_LORDS_DONATION WHERE AccountID = ?", [$AccountID["AccountID"]]);
                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                            $coins = $dB2->query_fetch_single("SELECT gold, gold_used FROM MEMB_CREDITS WHERE memb___id = ?", [$AccountID["AccountID"]]);
                        } else {
                            $coins = $dB->query_fetch_single("SELECT gold, gold_used FROM MEMB_CREDITS WHERE memb___id = ?", [$AccountID["AccountID"]]);
                        }
                        $total_level = $total_level + $AccountID["cLevel"] + $AccountID["mLevel"];
                        $total_donation = $total_donation + $donations["sum"];
                        $total_coins = $total_coins + $coins["gold"] + $coins["gold_used"];
                    }
                    if ($ranks[0]["req_level"] <= $total_level && $ranks[0]["req_donation"] <= $total_donation && $ranks[0]["req_coins"] <= $total_coins) {
                        $rank = 1;
                    } else {
                        if ($ranks[1]["req_level"] <= $total_level && $ranks[1]["req_donation"] <= $total_donation && $ranks[1]["req_coins"] <= $total_coins) {
                            $rank = 2;
                        } else {
                            if ($ranks[2]["req_level"] <= $total_level && $ranks[2]["req_donation"] <= $total_donation && $ranks[2]["req_coins"] <= $total_coins) {
                                $rank = 3;
                            } else {
                                if ($ranks[3]["req_level"] <= $total_level && $ranks[3]["req_donation"] <= $total_donation && $ranks[3]["req_coins"] <= $total_coins) {
                                    $rank = 4;
                                } else {
                                    if ($ranks[4]["req_level"] <= $total_level && $ranks[4]["req_donation"] <= $total_donation && $ranks[4]["req_coins"] <= $total_coins) {
                                        $rank = 5;
                                    } else {
                                        $rank = 0;
                                    }
                                }
                            }
                        }
                    }
                    $guildsOrdered[$i] = [$thisGuild["G_Name"], $thisGuild["G_Master"], $thisGuild["G_Mark"], $total_level + $total_donation + $total_coins, $rank];
                    $i++;
                }
                function sortByPoints($a, $b)
                {
                    return $b[3] - $a[3];
                }
                usort($guildsOrdered, "sortByPoints");
                $cacheDATA = BuildCacheData($guildsOrdered);
                UpdateCache("rankings_mulords.cache", $cacheDATA);
                break;
            case "married":
                $dbDATA = $dB->query_fetch("SELECT Name, MarryName FROM Character WHERE Married = 1");
                function multi_array_search($search_for, $search_in)
                {
                    foreach ($search_in as $element) {
                        if ($element === $search_for || is_array($element) && multi_array_search($search_for, $element)) {
                            return true;
                        }
                    }
                    return false;
                }
                $married = [];
                $i = 0;
                foreach ($dbDATA as $row) {
                    if (!multi_array_search($row["Name"], $married)) {
                        $married[$i] = [$row["Name"], $row["MarryName"]];
                    }
                    $i++;
                }
                $cacheDATA = BuildCacheData($married);
                UpdateCache("rankings_married.cache", $cacheDATA);
                break;
            case "score":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " c.Name, c.Class, c.cLevel, c.mLevel, c.RESETS, c.Grand_Resets, m.Country,\r\n                                            (\r\n                                                (ISNULL(c.cLevel, 0) * " . mconfig("score_rankings_lvl") . ") + (ISNULL(c.mLevel, 0) * " . mconfig("score_rankings_mlvl") . ")\r\n                                              + (ISNULL(c.RESETS, 0) * " . mconfig("score_rankings_reset") . ") + (ISNULL(c.Grand_Resets, 0) * " . mconfig("score_rankings_greset") . ")\r\n                                              + (ISNULL(c.Strength, 0) * " . mconfig("score_rankings_stats") . ") + (ISNULL(c.Dexterity, 0) * " . mconfig("score_rankings_stats") . ")\r\n                                              + (ISNULL(c.Vitality, 0) * " . mconfig("score_rankings_stats") . ") + (ISNULL(c.Energy, 0) * " . mconfig("score_rankings_stats") . ")\r\n                                              + (ISNULL(c.Leadership, 0) * " . mconfig("score_rankings_stats") . ") + (ISNULL(c.LevelUpPoint, 0) * " . mconfig("score_rankings_stats") . ")\r\n                                              + (ISNULL(c.WinDuels, 0) * " . mconfig("score_rankings_duel_win") . ") - (ISNULL(c.LoseDuels, 0) * " . mconfig("score_rankings_duel_lose") . ")\r\n                                              + (ISNULL(a.Points, 0) * " . mconfig("score_rankings_achiev") . ") +\r\n                                                CASE\r\n                                                    WHEN ISNULL(g.Rank, 0) = 0\r\n                                                        THEN 0\r\n                                                        ELSE (" . mconfig("score_rankings_gens_rank") . " / ISNULL(g.Rank, 0))\r\n                                                END\r\n                                              + (ISNULL(g.Points, 0) * " . mconfig("score_rankings_gens_points") . ") +\r\n                                                CASE\r\n                                                    WHEN ISNULL(g.Class, 0) = 0\r\n                                                        THEN 0\r\n                                                        ELSE (" . mconfig("score_rankings_gens_class") . " / ISNULL(g.Class, 0))\r\n                                                END\r\n                                              + (ISNULL((SELECT SUM(Point) FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO] WHERE AccountID = c.AccountID AND CharacterName = c.Name), 0) * " . mconfig("score_rankings_ds") . ")\r\n                                              + (ISNULL((SELECT SUM(Point) FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_BC_5TH] WHERE AccountID = c.AccountID AND CharacterName = c.Name), 0) * " . mconfig("score_rankings_bc") . ")\r\n                                              + (ISNULL((SELECT SUM(Wins) FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_CC] WHERE AccountID = c.AccountID AND Name = c.Name), 0) * " . mconfig("score_rankings_cc") . ")\r\n                                              + (ISNULL((SELECT SUM(TotalScore) FROM [" . $config["SQL_DB_NAME_RANKING"] . "].[dbo].[EVENT_INFO_IT] WHERE AccountID = c.AccountID AND Name = c.Name), 0) * " . mconfig("score_rankings_it") . ")\r\n                                            ) as TOTAL\r\n                                            FROM Character c\r\n                                            INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID\r\n                                            LEFT JOIN IMPERIAMUCMS_ACHIEVEMENTS_RANKING a ON c.Name = a.Name\r\n                                            LEFT JOIN IGC_Gens g on c.Name = g.Name\r\n                                            WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0\r\n                                            ORDER BY TOTAL DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_score.cache", $cacheDATA);
                break;
            case "honor":
                $dbDATA = $dB->query_fetch("SELECT c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.cLevel >= " . mconfig("honor_level") . "\r\n                AND c.mLevel >= " . mconfig("honor_mlevel") . " AND c.RESETS >= " . mconfig("honor_reset") . " \r\n                AND c.Grand_Resets >= " . mconfig("honor_greset") . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_honor.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["wizard"]) . ")\r\n                AND c.cLevel >= " . mconfig("honor_level") . "\r\n                AND c.mLevel >= " . mconfig("honor_mlevel") . " AND c.RESETS >= " . mconfig("honor_reset") . " \r\n                AND c.Grand_Resets >= " . mconfig("honor_greset") . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_honor_wizard.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["knight"]) . ")\r\n                AND c.cLevel >= " . mconfig("honor_level") . "\r\n                AND c.mLevel >= " . mconfig("honor_mlevel") . " AND c.RESETS >= " . mconfig("honor_reset") . " \r\n                AND c.Grand_Resets >= " . mconfig("honor_greset") . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_honor_knight.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["elf"]) . ")\r\n                AND c.cLevel >= " . mconfig("honor_level") . "\r\n                AND c.mLevel >= " . mconfig("honor_mlevel") . " AND c.RESETS >= " . mconfig("honor_reset") . " \r\n                AND c.Grand_Resets >= " . mconfig("honor_greset") . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_honor_elf.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["gladiator"]) . ")\r\n                AND c.cLevel >= " . mconfig("honor_level") . "\r\n                AND c.mLevel >= " . mconfig("honor_mlevel") . " AND c.RESETS >= " . mconfig("honor_reset") . " \r\n                AND c.Grand_Resets >= " . mconfig("honor_greset") . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_honor_gladiator.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["lord"]) . ")\r\n                AND c.cLevel >= " . mconfig("honor_level") . "\r\n                AND c.mLevel >= " . mconfig("honor_mlevel") . " AND c.RESETS >= " . mconfig("honor_reset") . " \r\n                AND c.Grand_Resets >= " . mconfig("honor_greset") . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_honor_lord.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["summoner"]) . ")\r\n                AND c.cLevel >= " . mconfig("honor_level") . "\r\n                AND c.mLevel >= " . mconfig("honor_mlevel") . " AND c.RESETS >= " . mconfig("honor_reset") . " \r\n                AND c.Grand_Resets >= " . mconfig("honor_greset") . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_honor_summoner.cache", $cacheDATA);
                $dbDATA = $dB->query_fetch("SELECT c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["fighter"]) . ")\r\n                AND c.cLevel >= " . mconfig("honor_level") . "\r\n                AND c.mLevel >= " . mconfig("honor_mlevel") . " AND c.RESETS >= " . mconfig("honor_reset") . " \r\n                AND c.Grand_Resets >= " . mconfig("honor_greset") . " " . $showOnlyActive . "\r\n                ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_honor_fighter.cache", $cacheDATA);
                if (100 <= config("server_files_season", true)) {
                    $dbDATA = $dB->query_fetch("SELECT c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                    INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                    INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["lancer"]) . ")\r\n                    AND c.cLevel >= " . mconfig("honor_level") . "\r\n                    AND c.mLevel >= " . mconfig("honor_mlevel") . " AND c.RESETS >= " . mconfig("honor_reset") . " \r\n                    AND c.Grand_Resets >= " . mconfig("honor_greset") . " " . $showOnlyActive . "\r\n                    ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                    $cacheDATA = BuildCacheData($dbDATA);
                    UpdateCache("rankings_honor_lancer.cache", $cacheDATA);
                }
                if (140 <= config("server_files_season", true)) {
                    $dbDATA = $dB->query_fetch("SELECT c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                    INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                    INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["rune"]) . ")\r\n                    AND c.cLevel >= " . mconfig("honor_level") . "\r\n                    AND c.mLevel >= " . mconfig("honor_mlevel") . " AND c.RESETS >= " . mconfig("honor_reset") . " \r\n                    AND c.Grand_Resets >= " . mconfig("honor_greset") . " " . $showOnlyActive . "\r\n                    ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                    $cacheDATA = BuildCacheData($dbDATA);
                    UpdateCache("rankings_honor_rune.cache", $cacheDATA);
                }
                if (150 <= config("server_files_season", true)) {
                    $dbDATA = $dB->query_fetch("SELECT c.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country FROM Character c\r\n                    INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                    INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND c.Class IN (" . implode(",", $custom["class_filter"]["slayer"]) . ")\r\n                    AND c.cLevel >= " . mconfig("honor_level") . "\r\n                    AND c.mLevel >= " . mconfig("honor_mlevel") . " AND c.RESETS >= " . mconfig("honor_reset") . " \r\n                    AND c.Grand_Resets >= " . mconfig("honor_greset") . " " . $showOnlyActive . "\r\n                    ORDER BY c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                    $cacheDATA = BuildCacheData($dbDATA);
                    UpdateCache("rankings_honor_slayer.cache", $cacheDATA);
                }
                break;
            case "afk":
                if (140 <= config("server_files_season", true)) {
                    $dbDATA = $dB->query_fetch("\r\n                    SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " hl.Name, c.Class, SUM(hl.HuntingAccrueSecond) as TotalTime, SUM(hl.NormalAccrueDamage) as TotalDmg, \r\n                    SUM(hl.PentagramAccrueDamage) as TotalElDmg, SUM(hl.MonsterKillCount) as TotalKills, SUM(hl.AccrueExp) as TotalExp, m.Country\r\n                    FROM IGC_HuntingRecord hl\r\n                    INNER JOIN Character c ON c.Name = hl.Name\r\n                    INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                    INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 " . $showOnlyActive . "\r\n                    GROUP BY hl.Name, c.Name, c.Class, m.Country\r\n                    ORDER BY " . mconfig("rankings_afk_order1") . " DESC, " . mconfig("rankings_afk_order2") . " DESC, " . mconfig("rankings_afk_order3") . " DESC,\r\n                         " . mconfig("rankings_afk_order4") . " DESC, " . mconfig("rankings_afk_order5") . " DESC");
                } else {
                    $dbDATA = $dB->query_fetch("\r\n                    SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " hl.Name, c.Class, SUM(hl.HuntingTime) as TotalTime, SUM(hl.DamageDeal) as TotalDmg, \r\n                    SUM(hl.ElementalDamageDeal) as TotalElDmg, SUM(hl.MonsterKillCount) as TotalKills, SUM(hl.GainExp) as TotalExp, m.Country\r\n                    FROM IGC_HuntingLog hl\r\n                    INNER JOIN Character c ON c.Name = hl.Name\r\n                    INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                    INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 " . $showOnlyActive . "\r\n                    GROUP BY hl.Name, c.Name, c.Class, m.Country\r\n                    ORDER BY " . mconfig("rankings_afk_order1") . " DESC, " . mconfig("rankings_afk_order2") . " DESC, " . mconfig("rankings_afk_order3") . " DESC,\r\n                         " . mconfig("rankings_afk_order4") . " DESC, " . mconfig("rankings_afk_order5") . " DESC");
                }
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_afk.cache", $cacheDATA);
                break;
            case "fast_resets":
                $dbDATA = $dB->query_fetch("\r\n                SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " cpl.Name,c.Class,CAST(cpl.TotalTime as BIGINT) as TotalTime,cpl.NewValue,m.Country \r\n                FROM IMPERIAMUCMS_CHARACTER_PROGRESS_LOGS cpl\r\n                INNER JOIN Character c ON c.Name = cpl.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = cpl.AccountID\r\n                WHERE cpl.Type = '1' AND TotalTime > 0 AND c.CtlCode = 0 AND cpl.Name NOT IN(" . rankingsExcludeChars() . ")\r\n                ORDER BY TotalTime ASC");
                $bestTime = $dbDATA[0]["TotalTime"];
                $i = 0;
                foreach ($dbDATA as $thisRow) {
                    $dbDATA[$i]["TimeDiff"] = $dbDATA[$i]["TotalTime"] - $bestTime;
                    $i++;
                }
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_fast_resets.cache", $cacheDATA);
                break;
            case "fast_grandresets":
                $dbDATA = $dB->query_fetch("\r\n                SELECT TOP " . mconfig("rankings_results")["@attributes"]["general"] . " cpl.Name,c.Class,MIN(CAST(cpl.TotalTime as BIGINT)) as TotalTime,MIN(cpl.NewValue) as NewValue,m.Country \r\n                FROM IMPERIAMUCMS_CHARACTER_PROGRESS_LOGS cpl\r\n                INNER JOIN Character c ON c.Name = cpl.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = cpl.AccountID\r\n                WHERE cpl.Type = '2' AND TotalTime > 0 AND c.CtlCode = 0 AND cpl.Name NOT IN(" . rankingsExcludeChars() . ")\r\n                GROUP BY cpl.Name, c.Class, m.Country \r\n                ORDER BY TotalTime ASC");
                $bestTime = $dbDATA[0]["TotalTime"];
                $i = 0;
                foreach ($dbDATA as $thisRow) {
                    $dbDATA[$i]["TimeDiff"] = $thisRow["TotalTime"] - $bestTime;
                    $i++;
                }
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("rankings_fast_gresets.cache", $cacheDATA);
                break;
            case "daily_characters":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country,\r\n                tc.cLevel as dailycLevel,tc.mLevel as dailymLevel,tc.RESETS as dailyRESETS,tc.Grand_Resets as dailyGrand_Resets\r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date = CAST(GETDATE() AS DATE)\r\n                ORDER BY tc." . $order1 . " DESC, tc." . $order2 . " DESC, tc." . $order3 . " DESC, tc." . $order4 . " DESC, c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_characters.cache", $cacheDATA);
                break;
            case "daily_level":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.Name,c.Class,c.cLevel,m.Country,tc.cLevel as dailycLevel FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date = CAST(GETDATE() AS DATE) \r\n                ORDER BY dailycLevel DESC, c.cLevel DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_level.cache", $cacheDATA);
                break;
            case "daily_master":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.Name,c.Class,c.mLevel,m.Country,tc.mLevel as dailymLevel FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date = CAST(GETDATE() AS DATE)\r\n                ORDER BY dailymLevel DESC, c.mLevel DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_master.cache", $cacheDATA);
                break;
            case "daily_resets":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.Name,c.Class,c.RESETS,m.Country,tc.RESETS as dailyRESETS FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date = CAST(GETDATE() AS DATE)\r\n                ORDER BY dailyRESETS DESC, c.RESETS DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_resets.cache", $cacheDATA);
                break;
            case "daily_grandresets":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.Name,c.Class,c.Grand_Resets,m.Country,tc.Grand_Resets as dailyGrand_Resets FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date = CAST(GETDATE() AS DATE)\r\n                ORDER BY dailyGrand_Resets DESC, c.Grand_Resets DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_gr.cache", $cacheDATA);
                break;
            case "daily_killers":
                if (mconfig("rankings_killers_type")) {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " c.Name, c.Class, COUNT(pk.Killer) as count, m.Country \r\n                    FROM C_PlayerKiller_Info pk\r\n                    INNER JOIN Character c ON c.Name = pk.Killer\r\n                    INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND CAST(pk.KillDate AS DATE) = CAST(GETDATE() AS DATE)\r\n                    GROUP BY pk.Killer, c.Name, c.Class, m.Country ORDER BY count DESC");
                } else {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.Name,c.Class,tc.PkCount,m.Country FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                    INNER JOIN Character c ON c.Name = tc.Name\r\n                    INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date = CAST(GETDATE() AS DATE)\r\n                    ORDER BY tc.PkCount DESC");
                }
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_pk.cache", $cacheDATA);
                break;
            case "daily_duels":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.Name,c.Class,tc.WinDuels,tc.LoseDuels,m.Country FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date = CAST(GETDATE() AS DATE) \r\n                ORDER BY tc.WinDuels DESC, tc.LoseDuels ASC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_duels.cache", $cacheDATA);
                break;
            case "daily_gens_points":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.Name,g.Class as GClass,g.Influence,g.Rank,g.Points,c.Class as CClass,m.Country,tc.Gens_Points FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN IGC_Gens g ON g.Name = tc.Name \r\n                WHERE Name NOT IN(" . rankingsExcludeChars() . ") AND CtlCode = 0 AND tc.Date = CAST(GETDATE() AS DATE)\r\n                ORDER BY tc.Gens_Points DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_gens_points.cache", $cacheDATA);
                break;
            case "daily_gens_kills":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.Name,c.Class,tc.Gens_Kills,m.Country FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE Name NOT IN(" . rankingsExcludeChars() . ") AND CtlCode = 0 AND tc.Date = CAST(GETDATE() AS DATE) \r\n                ORDER BY tc.Gens_Kills DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_gens_kills.cache", $cacheDATA);
                break;
            case "daily_devilsquare":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " te.Name,c.Class,te.DS_Points as Point,m.Country FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                LEFT JOIN " . $memb_info . " m ON m.memb___id = te.AccountID\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date = CAST(GETDATE() AS DATE)\r\n                ORDER BY Point DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_devilsquare.cache", $cacheDATA);
                break;
            case "daily_bloodcastle":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " te.Name,c.Class,te.BC_Points as Point,m.Country FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                LEFT JOIN " . $memb_info . " m ON m.memb___id = te.AccountID\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date = CAST(GETDATE() AS DATE)\r\n                ORDER BY Point DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_bloodcastle.cache", $cacheDATA);
                break;
            case "daily_chaoscastle":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " te.Name,c.Class,te.CC_Wins,te.CC_PKillCount,te.CC_MKillCount,m.Country FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                LEFT JOIN " . $memb_info . " m ON m.memb___id = te.AccountID\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date = CAST(GETDATE() AS DATE)\r\n                ORDER BY te.CC_Wins DESC, te.CC_PKillCount DESC, te.CC_MKillCount DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_chaoscastle.cache", $cacheDATA);
                break;
            case "daily_illusiontemple":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " te.Name,c.Class,te.IT_TotalScore,te.IT_Wins,te.IT_RelicsGivenCount,te.IT_KillCount,m.Country FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                LEFT JOIN " . $memb_info . " m ON m.memb___id = te.AccountID\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date = CAST(GETDATE() AS DATE)\r\n                ORDER BY te.IT_TotalScore DESC, te.IT_Wins DESC, te.IT_RelicsGivenCount DESC, te.IT_KillCount DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_illusiontemple.cache", $cacheDATA);
                break;
            case "daily_wcoin":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tp.Name,c.Class,tp.WCoin,m.Country FROM IMPERIAMUCMS_TRIGGER_INGAME_SHOP_POINT tp\r\n                INNER JOIN Character c ON c.Name = tp.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tp.Date = CAST(GETDATE() AS DATE) \r\n                ORDER BY tp.WCoin DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_wcoin.cache", $cacheDATA);
                break;
            case "daily_goblinpoint":
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tp.Name,c.Class,tp.GoblinPoint,m.Country FROM IMPERIAMUCMS_TRIGGER_INGAME_SHOP_POINT tp\r\n                INNER JOIN Character c ON c.Name = tp.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tp.Date = CAST(GETDATE() AS DATE) \r\n                ORDER BY tp.GoblinPoint DESC");
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_goblinpoint.cache", $cacheDATA);
                break;
            case "daily_guilds":
                if (mconfig("rankings_guild_type")) {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tg.G_Name,tg.G_Master,tg.G_Score,tg.cLevel,tg.mLevel,tg.RESETS,tg.Grand_Resets,\r\n                    CONVERT(varchar(max), G_Mark, 2) as G_Mark, (SELECT COUNT(*) FROM GuildMember WHERE G_Name = tg.G_Name) as TotalMembers \r\n                    FROM IMPERIAMUCMS_TRIGGER_GUILD tg\r\n                    INNER JOIN Guild g on g.G_Name = tg.G_Name\r\n                    WHERE tg.Date = CAST(GETDATE() AS DATE) \r\n                    ORDER BY tg." . $order1 . " DESC, tg." . $order2 . " DESC, tg." . $order3 . " DESC, tg." . $order4 . " DESC");
                } else {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tg.G_Name,tg.G_Master,tg.G_Score,tg.cLevel,tg.mLevel,tg.RESETS,tg.Grand_Resets,\r\n                    CONVERT(varchar(max), G_Mark, 2) as G_Mark, (SELECT COUNT(*) FROM GuildMember WHERE G_Name = tg.G_Name) as TotalMembers \r\n                    FROM IMPERIAMUCMS_TRIGGER_GUILD tg\r\n                    INNER JOIN Guild g on g.G_Name = tg.G_Name\r\n                    WHERE tg.Date = CAST(GETDATE() AS DATE) \r\n                    ORDER BY tg.G_Score DESC");
                }
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("daily_rankings/rankings_guilds.cache", $cacheDATA);
                break;
            case "weekly_characters":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country,\r\n                SUM(tc.cLevel) as dailycLevel,SUM(tc.mLevel) as dailymLevel,SUM(tc.RESETS) as dailyRESETS,SUM(tc.Grand_Resets) as dailyGrand_Resets\r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ?\r\n                GROUP BY tc.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country\r\n                ORDER BY daily" . $order1 . " DESC, daily" . $order2 . " DESC, daily" . $order3 . " DESC, daily" . $order4 . " DESC, c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC", [$startWeek, $endWeek]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_characters.cache", $cacheDATA);
                break;
            case "weekly_level":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.Name,c.Class,c.cLevel,m.Country,SUM(tc.cLevel) as weeklycLevel FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ?  \r\n                GROUP BY tc.Name,c.Class,c.cLevel,m.Country \r\n                ORDER BY weeklycLevel DESC, c.cLevel DESC", [$startWeek, $endWeek]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_level.cache", $cacheDATA);
                break;
            case "weekly_master":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.Name,c.Class,c.mLevel,m.Country,SUM(tc.mLevel) as weeklymLevel FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.Name,c.Class,c.mLevel,m.Country \r\n                ORDER BY weeklymLevel DESC, c.mLevel DESC", [$startWeek, $endWeek]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_master.cache", $cacheDATA);
                break;
            case "weekly_resets":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.Name,c.Class,c.RESETS,m.Country,SUM(tc.RESETS) as weeklyRESETS FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.Name,c.Class,c.RESETS,m.Country \r\n                ORDER BY weeklyRESETS DESC, c.RESETS DESC", [$startWeek, $endWeek]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_resets.cache", $cacheDATA);
                break;
            case "weekly_grandresets":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.Name,c.Class,c.Grand_Resets,m.Country,SUM(tc.Grand_Resets) as weeklyGrand_Resets FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.Name,c.Class,c.Grand_Resets,m.Country \r\n                ORDER BY weeklyGrand_Resets DESC, c.Grand_Resets DESC", [$startWeek, $endWeek]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_gr.cache", $cacheDATA);
                break;
            case "weekly_killers":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                if (mconfig("rankings_killers_type")) {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " c.Name, c.Class, COUNT(pk.Killer) as count, m.Country FROM C_PlayerKiller_Info pk\r\n                    INNER JOIN Character c ON c.Name = pk.Killer\r\n                    INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND CAST(pk.KillDate AS DATE) >= ? AND CAST(pk.KillDate AS DATE) <= ?\r\n                    GROUP BY pk.Killer, c.Name, c.Class, m.Country ORDER BY count DESC", [$startWeek, $endWeek]);
                } else {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.Name,c.Class,SUM(tc.PkCount) as PkCount,m.Country FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                    INNER JOIN Character c ON c.Name = tc.Name\r\n                    INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                    GROUP BY tc.Name,c.Class,m.Country \r\n                    ORDER BY PkCount DESC", [$startWeek, $endWeek]);
                }
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_pk.cache", $cacheDATA);
                break;
            case "weekly_duels":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.Name,c.Class,SUM(tc.WinDuels) as WinDuels,SUM(tc.LoseDuels) as LoseDuels,m.Country FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ?  \r\n                GROUP BY tc.Name,c.Class,m.Country \r\n                ORDER BY WinDuels DESC, LoseDuels ASC", [$startWeek, $endWeek]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_duels.cache", $cacheDATA);
                break;
            case "weekly_gens_points":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.Name,c.Class,SUM(tc.Gens_Points) as Gens_Points,m.Country FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE Name NOT IN(" . rankingsExcludeChars() . ") AND CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.Name,c.Class,m.Country \r\n                ORDER BY Gens_Points DESC", [$startWeek, $endWeek]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_gens_points.cache", $cacheDATA);
                break;
            case "weekly_gens_kills":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.Name,c.Class,SUM(tc.Gens_Kills) as Gens_Kills,m.Country FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE Name NOT IN(" . rankingsExcludeChars() . ") AND CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ?  \r\n                GROUP BY tc.Name,c.Class,m.Country \r\n                ORDER BY Gens_Kills DESC", [$startWeek, $endWeek]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_gens_kills.cache", $cacheDATA);
                break;
            case "weekly_devilsquare":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " te.Name,c.Class,SUM(te.DS_Points) as Point,m.Country FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                LEFT JOIN " . $memb_info . " m ON m.memb___id = te.AccountID\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.Name,c.Class,m.Country \r\n                ORDER BY Point DESC", [$startWeek, $endWeek]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_devilsquare.cache", $cacheDATA);
                break;
            case "weekly_bloodcastle":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " te.Name,c.Class,SUM(te.BC_Points) as Point,m.Country FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                LEFT JOIN " . $memb_info . " m ON m.memb___id = te.AccountID\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.Name,c.Class,m.Country \r\n                ORDER BY Point DESC", [$startWeek, $endWeek]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_bloodcastle.cache", $cacheDATA);
                break;
            case "weekly_chaoscastle":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " te.Name,c.Class,SUM(te.CC_Wins) as CC_Wins,SUM(te.CC_PKillCount) as CC_PKillCount,SUM(te.CC_MKillCount) as CC_MKillCount,m.Country FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                LEFT JOIN " . $memb_info . " m ON m.memb___id = te.AccountID\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.Name,c.Class,m.Country \r\n                ORDER BY CC_Wins DESC, CC_PKillCount DESC, CC_MKillCount DESC", [$startWeek, $endWeek]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_chaoscastle.cache", $cacheDATA);
                break;
            case "weekly_illusiontemple":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " te.Name,c.Class,SUM(te.IT_TotalScore) as IT_TotalScore,SUM(te.IT_Wins) as IT_Wins,SUM(te.IT_RelicsGivenCount) as IT_RelicsGivenCount,SUM(te.IT_KillCount) as IT_KillCount,m.Country FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                LEFT JOIN " . $memb_info . " m ON m.memb___id = te.AccountID\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.Name,c.Class,m.Country \r\n                ORDER BY IT_TotalScore DESC, IT_Wins DESC, IT_RelicsGivenCount DESC, IT_KillCount DESC", [$startWeek, $endWeek]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_illusiontemple.cache", $cacheDATA);
                break;
            case "weekly_wcoin":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tp.Name,c.Class,SUM(tp.WCoin) as WCoin,m.Country FROM IMPERIAMUCMS_TRIGGER_INGAME_SHOP_POINT tp\r\n                INNER JOIN Character c ON c.Name = tp.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tp.Date >= ? AND tp.Date <= ? \r\n                GROUP BY tp.Name,c.Class,m.Country \r\n                ORDER BY WCoin DESC", [$startWeek, $endWeek]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_wcoin.cache", $cacheDATA);
                break;
            case "weekly_goblinpoint":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tp.Name,c.Class,SUM(tp.GoblinPoint) as GoblinPoint,m.Country FROM IMPERIAMUCMS_TRIGGER_INGAME_SHOP_POINT tp\r\n                INNER JOIN Character c ON c.Name = tp.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tp.Date >= ? AND tp.Date <= ? \r\n                GROUP BY tp.Name,c.Class,m.Country \r\n                ORDER BY GoblinPoint DESC", [$startWeek, $endWeek]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_goblinpoint.cache", $cacheDATA);
                break;
            case "weekly_guilds":
                if (mconfig("rankings_week_start") == "sunday") {
                    $startDay = "sunday";
                    $startWeekDay = 7;
                    $endDay = "monday";
                } else {
                    $startDay = "monday";
                    $startWeekDay = 1;
                    $endDay = "sunday";
                }
                if (date("N", time()) == $startWeekDay) {
                    $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                } else {
                    $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                }
                $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                if (mconfig("rankings_guild_type")) {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tg.G_Name, tg.G_Master, SUM(tg.G_Score) as G_Score,\r\n                        SUM(tg.cLevel) as cLevel, SUM(tg.mLevel) as mLevel, SUM(tg.RESETS) as RESETS, SUM(tg.Grand_Resets) as Grand_Resets,\r\n                        CONVERT(varchar(max), g.G_Mark, 2) as G_Mark, (SELECT COUNT(*) FROM GuildMember WHERE G_Name = tg.G_Name) as TotalMembers \r\n                        FROM IMPERIAMUCMS_TRIGGER_GUILD tg\r\n                        INNER JOIN Guild g on g.G_Name = tg.G_Name\r\n                        WHERE tg.Date >= ? AND tg.Date <= ?\r\n                        GROUP BY tg.G_Name, tg.G_Master, G_Mark\r\n                        ORDER BY " . $order1 . " DESC, " . $order2 . " DESC, " . $order3 . " DESC, " . $order4 . " DESC", [$startWeek, $endWeek]);
                } else {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tg.G_Name, tg.G_Master, SUM(tg.G_Score) as G_Score,\r\n                        SUM(tg.cLevel) as cLevel, SUM(tg.mLevel) as mLevel, SUM(tg.RESETS) as RESETS, SUM(tg.Grand_Resets) as Grand_Resets,\r\n                        CONVERT(varchar(max), g.G_Mark, 2) as G_Mark, (SELECT COUNT(*) FROM GuildMember WHERE G_Name = tg.G_Name) as TotalMembers \r\n                        FROM IMPERIAMUCMS_TRIGGER_GUILD tg\r\n                        INNER JOIN Guild g on g.G_Name = tg.G_Name\r\n                        WHERE tg.Date >= ? AND tg.Date <= ?\r\n                        GROUP BY tg.G_Name, tg.G_Master, G_Mark\r\n                        ORDER BY G_Score DESC", [$startWeek, $endWeek]);
                }
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("weekly_rankings/rankings_guilds.cache", $cacheDATA);
                break;
            case "monthly_characters":
                $startMonth = date("Y-m-d", strtotime("first day of this month"));
                $endMonth = date("Y-m-d", strtotime("last day of this month"));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tc.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country,\r\n                SUM(tc.cLevel) as monthlycLevel,SUM(tc.mLevel) as monthlymLevel,SUM(tc.RESETS) as monthlyRESETS,SUM(tc.Grand_Resets) as monthlyGrand_Resets\r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                INNER JOIN " . $memb_stat . " ms ON ms.memb___id = c.AccountID\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ?\r\n                GROUP BY tc.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,m.Country\r\n                ORDER BY monthly" . $order1 . " DESC, monthly" . $order2 . " DESC, monthly" . $order3 . " DESC, monthly" . $order4 . " DESC, c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC", [$startMonth, $endMonth]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("monthly_rankings/rankings_characters.cache", $cacheDATA);
                break;
            case "monthly_level":
                $startMonth = date("Y-m-d", strtotime("first day of this month"));
                $endMonth = date("Y-m-d", strtotime("last day of this month"));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tc.Name,c.Class,c.cLevel,m.Country,SUM(tc.cLevel) as monthlycLevel FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.Name,c.Class,c.cLevel,m.Country \r\n                ORDER BY monthlycLevel DESC, c.cLevel DESC", [$startMonth, $endMonth]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("monthly_rankings/rankings_level.cache", $cacheDATA);
                break;
            case "monthly_master":
                $startMonth = date("Y-m-d", strtotime("first day of this month"));
                $endMonth = date("Y-m-d", strtotime("last day of this month"));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tc.Name,c.Class,c.mLevel,m.Country,SUM(tc.mLevel) as monthlymLevel FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.Name,c.Class,c.mLevel,m.Country \r\n                ORDER BY monthlymLevel DESC, c.mLevel DESC", [$startMonth, $endMonth]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("monthly_rankings/rankings_master.cache", $cacheDATA);
                break;
            case "monthly_resets":
                $startMonth = date("Y-m-d", strtotime("first day of this month"));
                $endMonth = date("Y-m-d", strtotime("last day of this month"));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tc.Name,c.Class,c.RESETS,m.Country,SUM(tc.RESETS) as monthlyRESETS FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.Name,c.Class,c.RESETS,m.Country \r\n                ORDER BY monthlyRESETS DESC, c.RESETS DESC", [$startMonth, $endMonth]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("monthly_rankings/rankings_resets.cache", $cacheDATA);
                break;
            case "monthly_grandresets":
                $startMonth = date("Y-m-d", strtotime("first day of this month"));
                $endMonth = date("Y-m-d", strtotime("last day of this month"));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tc.Name,c.Class,c.Grand_Resets,m.Country,SUM(tc.Grand_Resets) as monthlyGrand_Resets FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.Name,c.Class,c.Grand_Resets,m.Country \r\n                ORDER BY monthlyGrand_Resets DESC, c.Grand_Resets DESC", [$startMonth, $endMonth]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("monthly_rankings/rankings_gr.cache", $cacheDATA);
                break;
            case "monthly_killers":
                $startMonth = date("Y-m-d", strtotime("first day of this month"));
                $endMonth = date("Y-m-d", strtotime("last day of this month"));
                if (mconfig("rankings_killers_type")) {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " c.Name, c.Class, COUNT(pk.Killer) as count, m.Country FROM C_PlayerKiller_Info pk\r\n                    INNER JOIN Character c ON c.Name = pk.Killer\r\n                    INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND CAST(pk.KillDate AS DATE) >= ? AND CAST(pk.KillDate AS DATE) <= ?\r\n                    GROUP BY pk.Killer, c.Name, c.Class, m.Country ORDER BY count DESC", [$startMonth, $endMonth]);
                } else {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tc.Name,c.Class,SUM(tc.PkCount) as PkCount,m.Country FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                    INNER JOIN Character c ON c.Name = tc.Name\r\n                    INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                    GROUP BY tc.Name,c.Class,m.Country \r\n                    ORDER BY PkCount DESC", [$startMonth, $endMonth]);
                }
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("monthly_rankings/rankings_pk.cache", $cacheDATA);
                break;
            case "monthly_duels":
                $startMonth = date("Y-m-d", strtotime("first day of this month"));
                $endMonth = date("Y-m-d", strtotime("last day of this month"));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tc.Name,c.Class,SUM(tc.WinDuels) as WinDuels,SUM(tc.LoseDuels) as LoseDuels,m.Country FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                INNER JOIN " . $memb_info . " m ON m.memb___id = c.AccountID \r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ?  \r\n                GROUP BY tc.Name,c.Class,m.Country \r\n                ORDER BY WinDuels DESC, LoseDuels ASC", [$startMonth, $endMonth]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("monthly_rankings/rankings_duels.cache", $cacheDATA);
                break;
            case "monthly_votes":
                $voteMonth = date("Y-m-01 00:00", time());
                $voteMonthTimestamp = strtotime($voteMonth);
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " user_id,COUNT(*) as count,\r\n                                                SUM(CAST(timestamp as bigint) - 1500000000) as totalTime,\r\n                                                (SELECT TOP 1 Country FROM " . $memb_info . " WHERE memb_guid = user_id) as Country\r\n                                                FROM IMPERIAMUCMS_VOTES\r\n                                                WHERE timestamp >= ? AND confirm = 1 GROUP BY user_id ORDER BY count DESC, totalTime ASC", [$voteMonthTimestamp]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("monthly_rankings/rankings_votes.cache", $cacheDATA);
                break;
            case "monthly_devilsquare":
                $startMonth = date("Y-m-d", strtotime("first day of this month"));
                $endMonth = date("Y-m-d", strtotime("last day of this month"));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " te.Name,c.Class,SUM(te.DS_Points) as Point,m.Country FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                LEFT JOIN " . $memb_info . " m ON m.memb___id = te.AccountID\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.Name,c.Class,m.Country \r\n                ORDER BY Point DESC", [$startMonth, $endMonth]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("monthly_rankings/rankings_devilsquare.cache", $cacheDATA);
                break;
            case "monthly_bloodcastle":
                $startMonth = date("Y-m-d", strtotime("first day of this month"));
                $endMonth = date("Y-m-d", strtotime("last day of this month"));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " te.Name,c.Class,SUM(te.BC_Points) as Point,m.Country FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                LEFT JOIN " . $memb_info . " m ON m.memb___id = te.AccountID\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.Name,c.Class,m.Country \r\n                ORDER BY Point DESC", [$startMonth, $endMonth]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("monthly_rankings/rankings_bloodcastle.cache", $cacheDATA);
                break;
            case "monthly_chaoscastle":
                $startMonth = date("Y-m-d", strtotime("first day of this month"));
                $endMonth = date("Y-m-d", strtotime("last day of this month"));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " te.Name,c.Class,SUM(te.CC_Wins) as CC_Wins,SUM(te.CC_PKillCount) as CC_PKillCount,SUM(te.CC_MKillCount) as CC_MKillCount,m.Country FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                LEFT JOIN " . $memb_info . " m ON m.memb___id = te.AccountID\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.Name,c.Class,m.Country \r\n                ORDER BY CC_Wins DESC, CC_PKillCount DESC, CC_MKillCount DESC", [$startMonth, $endMonth]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("monthly_rankings/rankings_chaoscastle.cache", $cacheDATA);
                break;
            case "monthly_illusiontemple":
                $startMonth = date("Y-m-d", strtotime("first day of this month"));
                $endMonth = date("Y-m-d", strtotime("last day of this month"));
                $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " te.Name,c.Class,SUM(te.IT_TotalScore) as IT_TotalScore,SUM(te.IT_Wins) as IT_Wins,SUM(te.IT_RelicsGivenCount) as IT_RelicsGivenCount,SUM(te.IT_KillCount) as IT_KillCount,m.Country FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                LEFT JOIN " . $memb_info . " m ON m.memb___id = te.AccountID\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.Name,c.Class,m.Country \r\n                ORDER BY IT_TotalScore DESC, IT_Wins DESC, IT_RelicsGivenCount DESC, IT_KillCount DESC", [$startMonth, $endMonth]);
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("monthly_rankings/rankings_illusiontemple.cache", $cacheDATA);
                break;
            case "monthly_guilds":
                $startMonth = date("Y-m-d", strtotime("first day of this month"));
                $endMonth = date("Y-m-d", strtotime("last day of this month"));
                if (mconfig("rankings_guild_type")) {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tg.G_Name, tg.G_Master, SUM(tg.G_Score) as G_Score,\r\n                        SUM(tg.cLevel) as cLevel, SUM(tg.mLevel) as mLevel, SUM(tg.RESETS) as RESETS, SUM(tg.Grand_Resets) as Grand_Resets,\r\n                        CONVERT(varchar(max), g.G_Mark, 2) as G_Mark, (SELECT COUNT(*) FROM GuildMember WHERE G_Name = tg.G_Name) as TotalMembers \r\n                        FROM IMPERIAMUCMS_TRIGGER_GUILD tg\r\n                        INNER JOIN Guild g on g.G_Name = tg.G_Name\r\n                        WHERE tg.Date >= ? AND tg.Date <= ?\r\n                        GROUP BY tg.G_Name, tg.G_Master, G_Mark\r\n                        ORDER BY " . $order1 . " DESC, " . $order2 . " DESC, " . $order3 . " DESC, " . $order4 . " DESC", [$startMonth, $endMonth]);
                } else {
                    $dbDATA = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tg.G_Name, tg.G_Master, SUM(tg.G_Score) as G_Score,\r\n                        SUM(tg.cLevel) as cLevel, SUM(tg.mLevel) as mLevel, SUM(tg.RESETS) as RESETS, SUM(tg.Grand_Resets) as Grand_Resets,\r\n                        CONVERT(varchar(max), g.G_Mark, 2) as G_Mark, (SELECT COUNT(*) FROM GuildMember WHERE G_Name = tg.G_Name) as TotalMembers \r\n                        FROM IMPERIAMUCMS_TRIGGER_GUILD tg\r\n                        INNER JOIN Guild g on g.G_Name = tg.G_Name\r\n                        WHERE tg.Date >= ? AND tg.Date <= ?\r\n                        GROUP BY tg.G_Name, tg.G_Master, G_Mark\r\n                        ORDER BY G_Score DESC", [$startMonth, $endMonth]);
                }
                $cacheDATA = BuildCacheData($dbDATA);
                UpdateCache("monthly_rankings/rankings_guilds.cache", $cacheDATA);
                break;
            case "monster_hunter":
                $rankingsCfg = loadConfigurations("rankings");
                $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "monster_hunter.xml");
                if ($xml !== false) {
                    $array = [];
                    $i = 1;
                    $startMonth = date("Y-m-d", strtotime("first day of this month"));
                    $endMonth = date("Y-m-d", strtotime("last day of this month"));
                    if (mconfig("rankings_week_start") == "sunday") {
                        $startDay = "sunday";
                        $startWeekDay = 7;
                        $endDay = "monday";
                    } else {
                        $startDay = "monday";
                        $startWeekDay = 1;
                        $endDay = "sunday";
                    }
                    if (date("N", time()) == $startWeekDay) {
                        $startWeek = date("Y-m-d", strtotime("this " . $startDay));
                    } else {
                        $startWeek = date("Y-m-d", strtotime("last " . $startDay));
                    }
                    $endWeek = date("Y-m-d", strtotime("next " . $endDay));
                    foreach ($xml->children() as $tag => $monster) {
                        if ($monster["id"] == "-1") {
                            if ($monster["general"] == "1") {
                                $dbDATA = $dB->query_fetch("\r\n                                    SELECT TOP " . $rankingsCfg["rankings_monster_hunter_results_all"] . " mkc.name, c.Class, SUM(mkc.count) as count, m.Country\r\n                                    FROM C_Monster_KillCount mkc\r\n                                    LEFT JOIN Character c ON c.Name = mkc.name\r\n                                    LEFT JOIN " . $memb_info . " m ON m.memb___id = c.AccountID\r\n                                    WHERE mkc.name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0\r\n                                    GROUP BY mkc.name, c.Class, m.Country\r\n                                    ORDER BY count DESC");
                                $cacheDATA = BuildCacheData($dbDATA);
                                UpdateCache("monster_hunter/all_general.cache", $cacheDATA);
                            }
                            if ($monster["monthly"] == "1") {
                                $dbDATA = $dB->query_fetch("\r\n                                    SELECT TOP " . $rankingsCfg["rankings_monster_hunter_results_all"] . " tm.Name, c.Class, SUM(tm.Count) as count, m.Country\r\n                                    FROM IMPERIAMUCMS_TRIGGER_MONSTER tm\r\n                                    LEFT JOIN Character c ON c.Name = tm.Name\r\n                                    LEFT JOIN " . $memb_info . " m ON m.memb___id = tm.AccountID\r\n                                    WHERE tm.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tm.Date >= ? AND tm.Date <= ?\r\n                                    GROUP BY tm.Name, c.Class, m.Country\r\n                                    ORDER BY count DESC", [$startMonth, $endMonth]);
                                $cacheDATA = BuildCacheData($dbDATA);
                                UpdateCache("monster_hunter/all_monthly.cache", $cacheDATA);
                            }
                            if ($monster["weekly"] == "1") {
                                $dbDATA = $dB->query_fetch("\r\n                                    SELECT TOP " . $rankingsCfg["rankings_monster_hunter_results_all"] . " tm.Name, c.Class, SUM(tm.Count) as count, m.Country\r\n                                    FROM IMPERIAMUCMS_TRIGGER_MONSTER tm\r\n                                    LEFT JOIN Character c ON c.Name = tm.Name\r\n                                    LEFT JOIN " . $memb_info . " m ON m.memb___id = tm.AccountID\r\n                                    WHERE tm.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tm.Date >= ? AND tm.Date <= ?\r\n                                    GROUP BY tm.Name, c.Class, m.Country\r\n                                    ORDER BY count DESC", [$startWeek, $endWeek]);
                                $cacheDATA = BuildCacheData($dbDATA);
                                UpdateCache("monster_hunter/all_weekly.cache", $cacheDATA);
                            }
                            if ($monster["daily"] == "1") {
                                $dbDATA = $dB->query_fetch("\r\n                                    SELECT TOP " . $rankingsCfg["rankings_monster_hunter_results_all"] . " tm.Name, c.Class, SUM(tm.Count) as count, m.Country\r\n                                    FROM IMPERIAMUCMS_TRIGGER_MONSTER tm\r\n                                    LEFT JOIN Character c ON c.Name = tm.Name\r\n                                    LEFT JOIN " . $memb_info . " m ON m.memb___id = tm.AccountID\r\n                                    WHERE tm.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tm.Date = CAST(GETDATE() AS DATE)\r\n                                    GROUP BY tm.Name, c.Class, m.Country\r\n                                    ORDER BY count DESC");
                                $cacheDATA = BuildCacheData($dbDATA);
                                UpdateCache("monster_hunter/all_daily.cache", $cacheDATA);
                            }
                        } else {
                            if ($monster["general"] == "1") {
                                $dbDATA = $dB->query_fetch("\r\n                                    SELECT TOP " . $rankingsCfg["rankings_monster_hunter_results_monsters"] . " mkc.name, c.Class, SUM(mkc.count) as count, m.Country\r\n                                    FROM C_Monster_KillCount mkc\r\n                                    LEFT JOIN Character c ON c.Name = mkc.name\r\n                                    LEFT JOIN " . $memb_info . " m ON m.memb___id = c.AccountID\r\n                                    WHERE mkc.name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND mkc.MonsterId = ?\r\n                                    GROUP BY mkc.name, c.Class, m.Country\r\n                                    ORDER BY count DESC", [$monster["id"]]);
                                $cacheDATA = BuildCacheData($dbDATA);
                                UpdateCache("monster_hunter/" . $monster["id"] . "_general.cache", $cacheDATA);
                            }
                            if ($monster["monthly"] == "1") {
                                $dbDATA = $dB->query_fetch("\r\n                                    SELECT TOP " . $rankingsCfg["rankings_monster_hunter_results_monsters"] . " tm.Name, c.Class, SUM(tm.Count) as count, m.Country\r\n                                    FROM IMPERIAMUCMS_TRIGGER_MONSTER tm\r\n                                    LEFT JOIN Character c ON c.Name = tm.Name\r\n                                    LEFT JOIN " . $memb_info . " m ON m.memb___id = tm.AccountID\r\n                                    WHERE tm.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tm.MonsterID = ? AND tm.Date >= ? AND tm.Date <= ?\r\n                                    GROUP BY tm.Name, c.Class, m.Country\r\n                                    ORDER BY count DESC", [$monster["id"], $startMonth, $endMonth]);
                                $cacheDATA = BuildCacheData($dbDATA);
                                UpdateCache("monster_hunter/" . $monster["id"] . "_monthly.cache", $cacheDATA);
                            }
                            if ($monster["weekly"] == "1") {
                                $dbDATA = $dB->query_fetch("\r\n                                    SELECT TOP " . $rankingsCfg["rankings_monster_hunter_results_monsters"] . " tm.Name, c.Class, SUM(tm.Count) as count, m.Country\r\n                                    FROM IMPERIAMUCMS_TRIGGER_MONSTER tm\r\n                                    LEFT JOIN Character c ON c.Name = tm.Name\r\n                                    LEFT JOIN " . $memb_info . " m ON m.memb___id = tm.AccountID\r\n                                    WHERE tm.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tm.MonsterID = ? AND tm.Date >= ? AND tm.Date <= ?\r\n                                    GROUP BY tm.Name, c.Class, m.Country\r\n                                    ORDER BY count DESC", [$monster["id"], $startWeek, $endWeek]);
                                $cacheDATA = BuildCacheData($dbDATA);
                                UpdateCache("monster_hunter/" . $monster["id"] . "_weekly.cache", $cacheDATA);
                            }
                            if ($monster["daily"] == "1") {
                                $dbDATA = $dB->query_fetch("\r\n                                    SELECT TOP " . $rankingsCfg["rankings_monster_hunter_results_monsters"] . " tm.Name, c.Class, SUM(tm.Count) as count, m.Country\r\n                                    FROM IMPERIAMUCMS_TRIGGER_MONSTER tm\r\n                                    LEFT JOIN Character c ON c.Name = tm.Name\r\n                                    LEFT JOIN " . $memb_info . " m ON m.memb___id = tm.AccountID\r\n                                    WHERE tm.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tm.MonsterID = ? AND tm.Date = CAST(GETDATE() AS DATE)\r\n                                    GROUP BY tm.Name, c.Class, m.Country\r\n                                    ORDER BY count DESC", [$monster["id"], $startMonth, $endMonth]);
                                $cacheDATA = BuildCacheData($dbDATA);
                                UpdateCache("monster_hunter/" . $monster["id"] . "_daily.cache", $cacheDATA);
                            }
                        }
                    }
                }
                break;
        }
    }
    public function GetResults($limit = 10, $order = NULL, $direction = "DESC", $select = "*", $table = _TBL_CHR_, $group = NULL, $usedb2 = false)
    {
        global $dB;
        global $dB2;
        if (Validator::Number($limit)) {
            $build_query = "SELECT TOP " . $limit . " " . $select . " FROM " . $table . " ";
            if (check_value($group)) {
                $build_query .= "GROUP BY " . $group . " ";
            }
            if (check_value($order)) {
                $build_query .= "ORDER BY " . $order . " " . $direction;
            }
            if (config("SQL_USE_2_DB", true)) {
                if ($usedb2) {
                    $result = $dB2->query_fetch($build_query);
                } else {
                    $result = $dB->query_fetch($build_query);
                }
            } else {
                $result = $dB->query_fetch($build_query);
            }
            if (is_array($result)) {
                return $result;
            }
            return NULL;
        }
        return NULL;
    }
    public function rankingsMenu($displayHeader = true)
    {
        global $custom;
        $menuHtml = "";
        $show_rankings = $_REQUEST["subpage"];
        loadModuleConfigs("rankings");
        if ($custom["rankings_menu"] == NULL) {
            $rankings_menu = [["rankings_txt_54", "characters", "rankings_enable_characters"], ["rankings_txt_94", "monsterhunter", "rankings_enable_monster_hunter"], ["rankings_txt_70", "honor", "rankings_enable_honor"], ["rankings_txt_67", "score", "rankings_enable_score"], ["rankings_txt_4", "guilds", "rankings_enable_guilds"], ["rankings_txt_55", "onlineplayers", "rankings_enable_online_players"], ["rankings_txt_98", "fastresets", "rankings_enable_fast_resets"], ["rankings_txt_99", "fastgresets", "rankings_enable_fast_gresets"], ["rankings_txt_1", "level", "rankings_enable_level"], ["rankings_txt_22", "master", "rankings_enable_master"], ["rankings_txt_2", "resets", "rankings_enable_resets"], ["rankings_txt_5", "grandresets", "rankings_enable_gr"], ["rankings_txt_3", "killers", "rankings_enable_pk"], ["rankings_txt_56", "duels", "rankings_enable_duels"], ["rankings_txt_6", "online", "rankings_enable_online"], ["rankings_txt_71", "afk", "rankings_enable_afk"], ["rankings_txt_8", "gens", "rankings_enable_gens"], ["rankings_txt_7", "votes", "rankings_enable_votes"], ["rankings_txt_24", "pvplaststand", "rankings_enable_pvplaststand"], ["rankings_txt_57", "achievements", "rankings_enable_achievements"], ["rankings_txt_65", "married", "rankings_enable_married"], ["rankings_txt_58", "devilsquare", "rankings_enable_devilsquare"], ["rankings_txt_59", "bloodcastle", "rankings_enable_bloodcastle"], ["rankings_txt_60", "chaoscastle", "rankings_enable_chaoscastle"], ["rankings_txt_61", "illusiontemple", "rankings_enable_illusiontemple"], ["rankings_txt_62", "cshistory", "rankings_enable_cshistory"], ["arkawar_txt_1", "arkawar_history", "rankings_enable_arkawar_history"], ["icewindvalley_txt_1", "icewindvalley_history", "rankings_enable_icewindvalley_history"]];
        } else {
            $rankings_menu = $custom["rankings_menu"];
        }
        if ($displayHeader) {
            $menuHtml .= "\r\n        <div class=\"sub-page-title\">\r\n            <div id=\"title\"><h1>" . lang("module_titles_txt_10", true) . "<p></p><span></span></h1></div>\r\n        </div>";
        }
        $menuHtml .= "<div class=\"rankings_menu\">";
        foreach ($rankings_menu as $rm_item) {
            if (mconfig($rm_item[2])["@attributes"]["general"] == "1" || mconfig($rm_item[2])["@attributes"]["monthly"] == "1" || mconfig($rm_item[2])["@attributes"]["weekly"] == "1" || mconfig($rm_item[2])["@attributes"]["daily"] == "1") {
                if ($show_rankings == $rm_item[1]) {
                    $menuHtml .= "<div class=\"col-xs-6 col-sm-3 col-md-3 col-lg-2\"><a href=\"" . __PATH_MODULES_RANKINGS__ . $rm_item[1] . "/\" class=\"active\">" . lang($rm_item[0], true) . "</a></div>";
                } else {
                    $menuHtml .= "<div class=\"col-xs-6 col-sm-3 col-md-3 col-lg-2\"><a href=\"" . __PATH_MODULES_RANKINGS__ . $rm_item[1] . "/\">" . lang($rm_item[0], true) . "</a></div>";
                }
            }
        }
        $muLordsConf = loadConfigurations("mulords");
        $General = new xGeneral();
        if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("mulords") && $muLordsConf["active"]) {
            if ($show_rankings == "mulords") {
                $menuHtml .= "<div class=\"col-xs-6 col-sm-3 col-md-3 col-lg-2\"><a href=\"" . __PATH_MODULES_RANKINGS__ . "mulords" . "/\" class=\"active\">" . lang("rankings_txt_63", true) . "</a></div>";
            } else {
                $menuHtml .= "<div class=\"col-xs-6 col-sm-3 col-md-3 col-lg-2\"><a href=\"" . __PATH_MODULES_RANKINGS__ . "mulords" . "/\">" . lang("rankings_txt_63", true) . "</a></div>";
            }
        }
        $menuHtml .= "</div>";
        return $menuHtml;
    }
    public function monsterFilter()
    {
        $show_rankings = $_REQUEST["subpage"];
        $full_page = $show_rankings . "/" . $_REQUEST["request"];
        $xml = simplexml_load_file(__PATH_INCLUDES__ . "config/modules/monster_hunter.xml");
        if ($xml !== false) {
            $array = [];
            echo "<div class=\"rankings_menu_filter_monster\">";
            $isFirst = true;
            foreach ($xml->children() as $tag => $monster) {
                if ($monster["general"] == "1" || $monster["monthly"] == "1" || $monster["weekly"] == "1" || $monster["daily"] == "1") {
                    if ($monster["id"] == "-1") {
                        $monsterId = "all";
                    } else {
                        $monsterId = $monster["id"];
                    }
                    if ($full_page == "monsterhunter/monster/" . $monsterId || $isFirst && !isset($_GET["monster"])) {
                        echo "<a href=\"" . __PATH_MODULES_RANKINGS__ . "monsterhunter/monster/" . $monsterId . "\" class=\"active\">" . lang("monster_" . $monsterId, true) . "</a>";
                        $isFirst = false;
                    } else {
                        echo "<a href=\"" . __PATH_MODULES_RANKINGS__ . "monsterhunter/monster/" . $monsterId . "\">" . lang("monster_" . $monsterId, true) . "</a>";
                    }
                }
            }
            echo "</div>";
        }
    }
    public function classFilter()
    {
        $show_rankings = $_REQUEST["subpage"];
        $full_page = $show_rankings . "/" . $_REQUEST["request"];
        loadModuleConfigs("rankings");
        $filter_menu = [[lang("rankings_txt_64", true), $show_rankings . "/"], [lang("class_wizard", true), $show_rankings . "/class/wizard/"], [lang("class_knight", true), $show_rankings . "/class/knight/"], [lang("class_elf", true), $show_rankings . "/class/elf/"], [lang("class_summoner", true), $show_rankings . "/class/summoner/"], [lang("class_gladiator", true), $show_rankings . "/class/gladiator/"], [lang("class_lord", true), $show_rankings . "/class/lord/"], [lang("class_fighter", true), $show_rankings . "/class/fighter/"]];
        if (100 <= config("server_files_season", true)) {
            array_push($filter_menu, [lang("class_lancer", true), $show_rankings . "/class/lancer/"]);
        }
        if (140 <= config("server_files_season", true)) {
            array_push($filter_menu, [lang("class_rune", true), $show_rankings . "/class/rune/"]);
        }
        if (150 <= config("server_files_season", true)) {
            array_push($filter_menu, [lang("class_slayer", true), $show_rankings . "/class/slayer/"]);
        }
        echo "<div class=\"rankings_menu_filter\">";
        foreach ($filter_menu as $rm_item) {
            if ($full_page == $rm_item[1]) {
                echo "<a href=\"" . __PATH_MODULES_RANKINGS__ . $rm_item[1] . "\" class=\"active\">" . $rm_item[0] . "</a>";
            } else {
                echo "<a href=\"" . __PATH_MODULES_RANKINGS__ . $rm_item[1] . "\">" . $rm_item[0] . "</a>";
            }
        }
        echo "</div>";
    }
    public function gensFilter()
    {
        $show_rankings = $_REQUEST["subpage"];
        $full_page = $show_rankings . "/" . $_REQUEST["request"];
        loadModuleConfigs("rankings");
        $filter_menu = [[lang("rankings_txt_64", true), $show_rankings . "/"], [lang("rankings_txt_77", true), $show_rankings . "/filter/duprian/"], [lang("rankings_txt_78", true), $show_rankings . "/filter/vanert/"]];
        echo "<div class=\"rankings_menu_filter\">";
        foreach ($filter_menu as $rm_item) {
            if ($full_page == $rm_item[1]) {
                echo "<a href=\"" . __PATH_MODULES_RANKINGS__ . $rm_item[1] . "\" class=\"active\">" . $rm_item[0] . "</a>";
            } else {
                echo "<a href=\"" . __PATH_MODULES_RANKINGS__ . $rm_item[1] . "\">" . $rm_item[0] . "</a>";
            }
        }
        echo "</div>";
    }
    public function showRankingsPage($configName, $filter, $rankNumber = true, $columns)
    {
        loadModuleConfigs("rankings");
        if (mconfig("active")) {
            $showTabs = false;
            $totalRankings = 0;
            if (mconfig($configName)["@attributes"]["general"] == "1") {
                $totalRankings++;
            }
            if (mconfig($configName)["@attributes"]["daily"] == "1") {
                $totalRankings++;
            }
            if (mconfig($configName)["@attributes"]["weekly"] == "1") {
                $totalRankings++;
            }
            if (mconfig($configName)["@attributes"]["monthly"] == "1") {
                $totalRankings++;
            }
            if (1 < $totalRankings) {
                $showTabs = true;
            }
            if ($showTabs) {
                $html = "\r\n            <div role=\"tabpanel\" data-example-id=\"togglable-tabs\">\r\n                <ul id=\"rankingsTabs\" class=\"nav nav-tabs nav-tabs-responsive\" role=\"tablist\">";
                $isActive = "active";
                $isExpanded = "true";
                $count = 0;
                if (mconfig($configName)["@attributes"]["general"] == "1") {
                    $count++;
                    $html .= "\r\n                    <li role=\"presentation\" class=\"" . $isActive . "\">\r\n                        <a href=\"#general\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"general\" aria-expanded=\"" . $isExpanded . "\">\r\n                            <span class=\"text\">" . lang("rankings_txt_80", true) . "</span>\r\n                        </a>\r\n                    </li>";
                    $isActive = "";
                    $isExpanded = "false";
                }
                if (mconfig($configName)["@attributes"]["monthly"] == "1") {
                    $count++;
                    if ($count == 2) {
                        $isActive = "next";
                    }
                    $html .= "\r\n                    <li role=\"presentation\" class=\"" . $isActive . "\">\r\n                        <a href=\"#monthly\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"monthly\" aria-expanded=\"" . $isExpanded . "\">\r\n                            <span class=\"text\">" . lang("rankings_txt_83", true) . "</span>\r\n                        </a>\r\n                    </li>";
                    $isActive = "";
                    $isExpanded = "false";
                }
                if (mconfig($configName)["@attributes"]["weekly"] == "1") {
                    $count++;
                    if ($count == 2) {
                        $isActive = "next";
                    }
                    $html .= "\r\n                    <li role=\"presentation\" class=\"" . $isActive . "\">\r\n                        <a href=\"#weekly\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"weekly\" aria-expanded=\"" . $isExpanded . "\">\r\n                            <span class=\"text\">" . lang("rankings_txt_82", true) . "</span>\r\n                        </a>\r\n                    </li>";
                    $isActive = "";
                    $isExpanded = "false";
                }
                if (mconfig($configName)["@attributes"]["daily"] == "1") {
                    $count++;
                    if ($count == 2) {
                        $isActive = "next";
                    }
                    $html .= "\r\n                    <li role=\"presentation\" class=\"" . $isActive . "\">\r\n                        <a href=\"#daily\" id=\"general-tab\" role=\"tab\" data-toggle=\"tab\" aria-controls=\"daily\" aria-expanded=\"" . $isExpanded . "\">\r\n                            <span class=\"text\">" . lang("rankings_txt_81", true) . "</span>\r\n                        </a>\r\n                    </li>";
                    $isActive = "";
                    $isExpanded = "false";
                }
                $html .= "\r\n                </ul>\r\n                <div id=\"rankingsContent\" class=\"tab-content\">\r\n                    <div role=\"tabpanel\" class=\"tab-pane fade in active\" id=\"general\" aria-labelledby=\"general-tab\">";
            }
            $cacheFilter = "";
            if ($filter == "1") {
                $this->classFilter();
                if (isset($_GET["class"])) {
                    $cacheFilter = "_" . xss_clean($_GET["class"]);
                }
            } else {
                if ($filter == "2") {
                    $this->gensFilter();
                    if (isset($_GET["filter"])) {
                        $cacheFilter = "_" . xss_clean($_GET["filter"]);
                    }
                }
            }
            $rankingsData = LoadCacheData($configName . $cacheFilter . ".cache");
            $html .= "\r\n                        <div class=\"table-responsive rankings-table\">\r\n                            <table class=\"table table-hover text-center\">\r\n                                <thead>\r\n                                    <tr>";
            if (mconfig("rankings_show_place_number") && $rankNumber) {
                $html .= "<th>#</th>";
            }
            foreach ($columns["head"] as $thisHead) {
                $html .= "<th>" . lang($thisHead, true) . "</th>";
            }
            $html .= "\r\n                                    </tr>\r\n                                </thead>\r\n                                <tbody>";
            $i = 0;
            foreach ($rankingsData as $rdata) {
                if (1 <= $i) {
                }
                $i++;
            }
            $html .= "\r\n                                </tbody>\r\n                            </table>\r\n                        </div>";
            if ($showTabs) {
                $html .= "\r\n                    </div>\r\n                </div>\r\n            </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
    }
    public function returnRewardsHtml($type)
    {
        global $dB;
        global $config;
        global $common;
        global $custom;
        $Items = new Items();
        $rewards = $dB->query_fetch("\r\n            SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n            FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n            WHERE Active = ? AND Type = ?\r\n            ORDER BY Highest_Rank ASC", [1, $type]);
        if (is_array($rewards)) {
            if (explode("_", $type)[0] == "daily") {
                $rewardTitle = lang("rankings_txt_81", true);
            } else {
                if (explode("_", $type)[0] == "weekly") {
                    $rewardTitle = lang("rankings_txt_82", true);
                } else {
                    if (explode("_", $type)[0] == "monthly") {
                        $rewardTitle = lang("rankings_txt_83", true);
                    }
                }
            }
            $html = "\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12 col-lg-5\">\r\n                <div class=\"text-center rankings-rewards-title\">" . $rewardTitle . " " . lang("rankings_txt_92", true) . "</div>\r\n                <div class=\"table-responsive rankings-table\">\r\n                    <table class=\"table table-hover text-center\">\r\n                        <tr>\r\n                            <th class=\"headerRow\">" . lang("rankings_txt_89", true) . "</th>\r\n                            <th class=\"headerRow\">" . lang("rankings_txt_90", true) . "</th>\r\n                            <th class=\"headerRow\">" . lang("rankings_txt_91", true) . "</th>\r\n                        </tr>";
            foreach ($rewards as $thisReward) {
                if ($thisReward["Reward_Items_Type"] == 1) {
                    $rewardItemsType = lang("claimreward_txt_9", true);
                } else {
                    if ($thisReward["Reward_Items_Type"] == 2) {
                        $rewardItemsType = lang("claimreward_txt_10", true);
                    } else {
                        if ($thisReward["Reward_Items_Type"] == 3) {
                            $rewardItemsType = lang("claimreward_txt_11", true);
                        }
                    }
                }
                $currName = "";
                switch ($thisReward["Reward_Amount_Type"]) {
                    case "1":
                        $currName = lang("currency_platinum", true);
                        break;
                    case "2":
                        $currName = lang("currency_gold", true);
                        break;
                    case "3":
                        $currName = lang("currency_silver", true);
                        break;
                    case "4":
                        $currName = lang("currency_wcoinc", true);
                        break;
                    case "5":
                        $currName = lang("currency_gp", true);
                        break;
                    case "6":
                        $currName = lang("currency_zen", true);
                        break;
                    case "7":
                        $currName = lang("currency_wcoinp", true);
                        break;
                    case "8":
                        $currName = lang("currency_ruud", true);
                        break;
                    default:
                        $currReward = "--";
                        if (0 < $thisReward["Reward_Amount"] && $currName != "") {
                            $currReward = number_format($thisReward["Reward_Amount"]) . " " . $currName;
                        }
                        if (!empty($thisReward["Reward_Items"])) {
                            $rewardItems = explode(",", $thisReward["Reward_Items"]);
                            $rewardItemsShow = "";
                            $j = 0;
                            foreach ($rewardItems as $thisItem) {
                                $itemData = explode(":", $thisItem);
                                list($itemHex, $itemExp) = $itemData;
                                $itemInfo = $Items->ItemInfo($itemHex);
                                $rewardItemsShow .= "<span style=\"cursor: pointer;\" onmouseover=\"Tip(" . $Items->generateItemTooltip($itemInfo, 1, 0, 1, 1, 1, $itemExp) . ")\" onmouseout=\"UnTip()\">" . $itemInfo["name"] . "</span>";
                                if ($j != count($rewardItems) - 1) {
                                    $rewardItemsShow .= ", ";
                                }
                                $j++;
                            }
                            $rewardItemsShow = $rewardItemsType . " - " . $rewardItemsShow;
                        } else {
                            $rewardItemsShow = "--";
                        }
                        $html .= "\r\n                        <tr>\r\n                            <td>" . $thisReward["Highest_Rank"] . " - " . $thisReward["Lowest_Rank"] . "</td>\r\n                            <td>" . $currReward . "</td>\r\n                            <td>" . $rewardItemsShow . "<br></td>\r\n                        </tr>";
                }
            }
            $html .= "\r\n                    </table>\r\n                </div>\r\n            </div>\r\n            <div class=\"col-xs-12 col-lg-7\">";
            $rankingTypeTmp = explode("_", $type);
            $periodType = $rankingTypeTmp[0];
            $rankingType = "";
            $typeCounter = 1;
            while ($typeCounter < count($rankingTypeTmp)) {
                if ($rankingType == "") {
                    $rankingType .= $rankingTypeTmp[$typeCounter];
                } else {
                    $rankingType .= "_" . $rankingTypeTmp[$typeCounter];
                }
                $typeCounter++;
            }
            if ($periodType == "daily") {
                $totalHistoryPeriods = 7;
            } else {
                if ($periodType == "weekly") {
                    $totalHistoryPeriods = 5;
                } else {
                    if ($periodType == "monthly") {
                        $totalHistoryPeriods = 3;
                    }
                }
            }
            $periodsData = $dB->query_fetch("\r\n                        SELECT DISTINCT TOP " . $totalHistoryPeriods . " Period_Start, Period_End\r\n                        FROM IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                        WHERE Type = ? AND Period_Type = ?\r\n                        ORDER BY Period_Start DESC\r\n                    ", [$rankingType, $periodType]);
            if (is_array($periodsData)) {
                $html .= "\r\n                <div id=\"carousel-" . $periodType . "-" . $rankingType . "\" class=\"carousel slide\" data-ride=\"carousel\">\r\n                    <div class=\"carousel-inner\" role=\"listbox\">";
                if (config("SQL_USE_2_DB", true)) {
                    $memb_info = "[" . $config["SQL_DB_2_NAME"] . "].[dbo].[MEMB_INFO]";
                    $memb_stat = "[" . $config["SQL_DB_2_NAME"] . "].[dbo].[MEMB_STAT]";
                } else {
                    $memb_info = "[" . $config["SQL_DB_NAME"] . "].[dbo].[MEMB_INFO]";
                    $memb_stat = "[" . $config["SQL_DB_NAME"] . "].[dbo].[MEMB_STAT]";
                }
                $i = 1;
                foreach ($periodsData as $thisPeriod) {
                    $active = "";
                    if ($i == 1) {
                        $active = " active";
                    }
                    $winnersData = $dB->query_fetch("\r\n                                SELECT rrl.Name as Name, rrl.Rank as Rank, m.Country as Country\r\n                                FROM IMPERIAMUCMS_RANKINGS_REWARDS_LOGS rrl\r\n                                INNER JOIN " . $memb_info . " m ON m.memb___id = rrl.AccountID\r\n                                WHERE rrl.Period_Start = ? AND rrl.Period_End = ? AND rrl.Type = ? AND rrl.Period_Type = ?\r\n                                ORDER BY rrl.Rank ASC\r\n                            ", [$thisPeriod["Period_Start"], $thisPeriod["Period_End"], $rankingType, $periodType]);
                    if ($thisPeriod["Period_Start"] == $thisPeriod["Period_End"]) {
                        $period = date($config["date_format"], strtotime($thisPeriod["Period_Start"]));
                    } else {
                        $period = date($config["date_format"], strtotime($thisPeriod["Period_Start"])) . " - " . date($config["date_format"], strtotime($thisPeriod["Period_End"]));
                    }
                    $html .= "\r\n                        <div class=\"item" . $active . "\">\r\n                            <section>\r\n                                <div class=\"text-center rankings-rewards-title\">\r\n                                    " . sprintf(lang("rankings_txt_93", true), $rewardTitle, $period) . "\r\n                                </div>\r\n                                <div class=\"table-responsive rankings-table\">\r\n                                    <table class=\"table table-hover text-center\">";
                    if (is_array($winnersData)) {
                        foreach ($winnersData as $thisWinner) {
                            if ($thisWinner["Rank"] == 1) {
                                $html .= "\r\n                                        <tr>\r\n                                            <th class=\"headerRow rankings-rewards-1st-place\" colspan=\"4\">\r\n                                                " . $thisWinner["Rank"] . ". <a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($thisWinner["Name"]) . "/\">" . $common->replaceHtmlSymbols($thisWinner["Name"]) . "</a>";
                                if ($config["flags"]) {
                                    $html .= "&nbsp;<img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $thisWinner["Country"] . " rankings-rewards-flag\" alt=\"" . $custom["countries"][$thisWinner["Country"]] . "\" title=\"" . $custom["countries"][$thisWinner["Country"]] . "\" />";
                                }
                                $html .= "\r\n                                            </th>\r\n                                        </tr>";
                            } else {
                                if ($thisWinner["Rank"] == 2) {
                                    $html .= "\r\n                                        <tr>\r\n                                            <th class=\"headerRow rankings-rewards-2nd-place\" colspan=\"2\">\r\n                                                " . $thisWinner["Rank"] . ". <a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($thisWinner["Name"]) . "/\">" . $common->replaceHtmlSymbols($thisWinner["Name"]) . "</a>";
                                    if ($config["flags"]) {
                                        $html .= "&nbsp;<img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $thisWinner["Country"] . " rankings-rewards-flag\" alt=\"" . $custom["countries"][$thisWinner["Country"]] . "\" title=\"" . $custom["countries"][$thisWinner["Country"]] . "\" />";
                                    }
                                    $html .= "\r\n                                            </th>";
                                } else {
                                    if ($thisWinner["Rank"] == 3) {
                                        $html .= "\r\n                                            <th class=\"headerRow rankings-rewards-3rd-place\" colspan=\"2\">\r\n                                                " . $thisWinner["Rank"] . ". <a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($thisWinner["Name"]) . "/\">" . $common->replaceHtmlSymbols($thisWinner["Name"]) . "</a>";
                                        if ($config["flags"]) {
                                            $html .= "&nbsp;<img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $thisWinner["Country"] . " rankings-rewards-flag\" alt=\"" . $custom["countries"][$thisWinner["Country"]] . "\" title=\"" . $custom["countries"][$thisWinner["Country"]] . "\" />";
                                        }
                                        $html .= "\r\n                                            </th>\r\n                                        </tr>";
                                    } else {
                                        if (($thisWinner["Rank"] - 3) % 4 == 1) {
                                            $html .= "<tr>";
                                        }
                                        $html .= "\r\n                                            <td>\r\n                                                " . $thisWinner["Rank"] . ". <a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($thisWinner["Name"]) . "/\">" . $common->replaceHtmlSymbols($thisWinner["Name"]) . "</a>";
                                        if ($config["flags"]) {
                                            $html .= "&nbsp;<img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $thisWinner["Country"] . " rankings-rewards-flag\" alt=\"" . $custom["countries"][$thisWinner["Country"]] . "\" title=\"" . $custom["countries"][$thisWinner["Country"]] . "\" />";
                                        }
                                        $html .= "\r\n                                            </td>";
                                        if (($thisWinner["Rank"] - 3) % 4 == 0) {
                                            $html .= "</tr>";
                                        }
                                    }
                                }
                            }
                        }
                        if (substr($html, -5) != "</tr>") {
                            $html .= "</tr>";
                        }
                    }
                    $html .= "\r\n                                    </table>\r\n                                </div>\r\n                            </section>\r\n                        </div>";
                    $i++;
                }
                $html .= "\r\n                    </div>\r\n                    <ol class=\"carousel-indicators\">";
                $periodCounter = 0;
                foreach ($periodsData as $thisPeriod) {
                    $active = "";
                    if ($periodCounter == 0) {
                        $active = " class=\"active\"";
                    }
                    $html .= "\r\n                        <li data-target=\"#carousel-" . $periodType . "-" . $rankingType . "\" data-slide-to=\"" . $periodCounter . "\"" . $active . "></li>";
                    $periodCounter++;
                }
                $html .= "\r\n                    </ol>\r\n                </div>";
            }
            $html .= "\r\n            </div>\r\n        </div>";
            return $html;
        } else {
            return NULL;
        }
    }
    public function giveBadge($type, $rankingsData, $period, $type1, $type2, $monsterId = NULL)
    {
        global $dB;
        $rank = 1;
        $badgesCfg = loadConfigurations("badges");
        $maxRank = $badgesCfg["max_rank"];
        foreach ($rankingsData as $thisUser) {
            if ($rank <= $maxRank) {
                if ($type == 1) {
                    $dB->query("\r\n                        INSERT INTO IMPERIAMUCMS_BADGES_REWARDS (BadgeID, AccountID, Name, Date, Tooltip, Status, MonsterID) \r\n                        VALUES ((SELECT id FROM IMPERIAMUCMS_BADGES WHERE Type1 = ? AND Type2 = ?), ?, ?, ?, ?, ?, ?)", [$type1, $type2, $thisUser["AccountID"], $thisUser["Name"], date("Y-m-d H:i:s", time()), $rank . ";" . $period, 1, $monsterId]);
                } else {
                    if ($type == 2) {
                        $dB->query("\r\n                        INSERT INTO IMPERIAMUCMS_BADGES_REWARDS (BadgeID, GuildNumber, Date, Tooltip, Status, MonsterID) \r\n                        VALUES ((SELECT id FROM IMPERIAMUCMS_BADGES WHERE Type1 = ? AND Type2 = ?), (SELECT Number FROM Guild WHERE G_Name = ?), ?, ?, ?, ?)", [$type1, $type2, $thisUser["G_Name"], date("Y-m-d H:i:s", time()), $rank . ";" . $period, 1, $monsterId]);
                    } else {
                        if ($type == 3) {
                            $dB->query("\r\n                        INSERT INTO IMPERIAMUCMS_BADGES_REWARDS (BadgeID, AccountID, Date, Tooltip, Status, MonsterID) \r\n                        VALUES ((SELECT id FROM IMPERIAMUCMS_BADGES WHERE Type1 = ? AND Type2 = ?), ?, ?, ?, ?, ?, ?)", [$type1, $type2, $thisUser["AccountID"], $thisUser["Name"], date("Y-m-d H:i:s", time()), $rank . ";" . $period, 1, $monsterId]);
                        }
                    }
                }
                $rank++;
            }
        }
    }
    public function giveRankingsRewards($ranking, $type, $periodStart, $periodEnd, $monster = NULL)
    {
        global $dB;
        global $config;
        $adminName = "";
        foreach ($config["admins"] as $thisAdmin => $accessLevel) {
            if (100 <= $accessLevel) {
                $adminName = $thisAdmin;
                if (config("SQL_USE_2_DB", true)) {
                    $memb_info = "[" . $config["SQL_DB_2_NAME"] . "].[dbo].[MEMB_INFO]";
                    $memb_stat = "[" . $config["SQL_DB_2_NAME"] . "].[dbo].[MEMB_STAT]";
                } else {
                    $memb_info = "[" . $config["SQL_DB_NAME"] . "].[dbo].[MEMB_INFO]";
                    $memb_stat = "[" . $config["SQL_DB_NAME"] . "].[dbo].[MEMB_STAT]";
                }
                $order1 = mconfig("order_priority_1");
                $order2 = mconfig("order_priority_2");
                $order3 = mconfig("order_priority_3");
                $order4 = mconfig("order_priority_4");
                if ($ranking == "characters") {
                    if ($type == "daily") {
                        $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.AccountID,tc.Name,\r\n                    tc.cLevel as dailycLevel,tc.mLevel as dailymLevel,tc.RESETS as dailyRESETS,tc.Grand_Resets as dailyGrand_Resets\r\n                    FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                    INNER JOIN Character c ON c.Name = tc.Name\r\n                    WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date = ?\r\n                    ORDER BY tc." . $order1 . " DESC, tc." . $order2 . " DESC, tc." . $order3 . " DESC, tc." . $order4 . " DESC, c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC", [$periodStart]);
                        $this->giveBadge(1, $data, $periodStart, 1, 3);
                        $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "daily_characters"]);
                        if (is_array($rewards) && is_array($data)) {
                            $i = 0;
                            foreach ($rewards as $thisReward) {
                                $j = $thisReward["Highest_Rank"];
                                while ($j <= $thisReward["Lowest_Rank"]) {
                                    $arrayIndex = $j - 1;
                                    $userToReward = $data[$arrayIndex];
                                    if (is_array($userToReward)) {
                                        $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_81", true), lang("rankings_txt_54", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                        $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                    }
                                    $j++;
                                }
                                $i++;
                            }
                        }
                    } else {
                        if ($type == "weekly") {
                            $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.AccountID,tc.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,\r\n                SUM(tc.cLevel) as dailycLevel,SUM(tc.mLevel) as dailymLevel,SUM(tc.RESETS) as dailyRESETS,SUM(tc.Grand_Resets) as dailyGrand_Resets\r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ?\r\n                GROUP BY tc.AccountID,tc.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets\r\n                ORDER BY daily" . $order1 . " DESC, daily" . $order2 . " DESC, daily" . $order3 . " DESC, daily" . $order4 . " DESC, c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC", [$periodStart, $periodEnd]);
                            $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 1, 2);
                            $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "weekly_characters"]);
                            if (is_array($rewards) && is_array($data)) {
                                $i = 0;
                                foreach ($rewards as $thisReward) {
                                    $j = $thisReward["Highest_Rank"];
                                    while ($j <= $thisReward["Lowest_Rank"]) {
                                        $arrayIndex = $j - 1;
                                        $userToReward = $data[$arrayIndex];
                                        if (is_array($userToReward)) {
                                            $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_82", true), lang("rankings_txt_54", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                            $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                        }
                                        $j++;
                                    }
                                    $i++;
                                }
                            }
                        } else {
                            if ($type == "monthly") {
                                $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tc.AccountID,tc.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets,\r\n                SUM(tc.cLevel) as monthlycLevel,SUM(tc.mLevel) as monthlymLevel,SUM(tc.RESETS) as monthlyRESETS,SUM(tc.Grand_Resets) as monthlyGrand_Resets\r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ?\r\n                GROUP BY tc.AccountID,tc.Name,c.Class,c.cLevel,c.mLevel,c.RESETS,c.Grand_Resets\r\n                ORDER BY monthly" . $order1 . " DESC, monthly" . $order2 . " DESC, monthly" . $order3 . " DESC, monthly" . $order4 . " DESC, c." . $order1 . " DESC, c." . $order2 . " DESC, c." . $order3 . " DESC, c." . $order4 . " DESC", [$periodStart, $periodEnd]);
                                $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 1, 1);
                                $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "monthly_characters"]);
                                if (is_array($rewards) && is_array($data)) {
                                    $i = 0;
                                    foreach ($rewards as $thisReward) {
                                        $j = $thisReward["Highest_Rank"];
                                        while ($j <= $thisReward["Lowest_Rank"]) {
                                            $arrayIndex = $j - 1;
                                            $userToReward = $data[$arrayIndex];
                                            if (is_array($userToReward)) {
                                                $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_83", true), lang("rankings_txt_54", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                                $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                            }
                                            $j++;
                                        }
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($ranking == "guilds") {
                    if ($type == "daily") {
                        if (mconfig("rankings_guild_type")) {
                            $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tg.G_Name\r\n                        FROM IMPERIAMUCMS_TRIGGER_GUILD tg\r\n                        WHERE tg.Date = CAST(GETDATE() AS DATE)\r\n                        ORDER BY tg." . $order1 . " DESC, tg." . $order2 . " DESC, tg." . $order3 . " DESC, tg." . $order4 . " DESC", [$periodStart]);
                        } else {
                            $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tg.G_Name\r\n                        FROM IMPERIAMUCMS_TRIGGER_GUILD tg\r\n                        WHERE tg.Date = CAST(GETDATE() AS DATE)\r\n                        ORDER BY tg.G_Score DESC", [$periodStart]);
                        }
                        $this->giveBadge(2, $data, $periodStart, 3, 3);
                    } else {
                        if ($type == "weekly") {
                            if (mconfig("rankings_guild_type")) {
                                $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tg.G_Name, SUM(tg.cLevel) as cLevel, SUM(tg.mLevel) as mLevel, \r\n                            SUM(tg.RESETS) as RESETS, SUM(tg.Grand_Resets) as Grand_Resets\r\n                        FROM IMPERIAMUCMS_TRIGGER_GUILD tg\r\n                        WHERE tg.Date >= ? AND tg.Date <= ?\r\n                        GROUP BY tg.G_Name\r\n                        ORDER BY " . $order1 . " DESC, " . $order2 . " DESC, " . $order3 . " DESC, " . $order4 . " DESC", [$periodStart, $periodEnd]);
                            } else {
                                $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tg.G_Name, SUM(tg.G_Score) as G_Score\r\n                        FROM IMPERIAMUCMS_TRIGGER_GUILD tg\r\n                        WHERE tg.Date >= ? AND tg.Date <= ?\r\n                        GROUP BY tg.G_Name\r\n                        ORDER BY G_Score DESC", [$periodStart, $periodEnd]);
                            }
                            $this->giveBadge(2, $data, $periodStart . " - " . $periodEnd, 3, 2);
                        } else {
                            if ($type == "monthly") {
                                if (mconfig("rankings_guild_type")) {
                                    $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tg.G_Name, SUM(tg.cLevel) as cLevel, SUM(tg.mLevel) as mLevel, \r\n                            SUM(tg.RESETS) as RESETS, SUM(tg.Grand_Resets) as Grand_Resets\r\n                        FROM IMPERIAMUCMS_TRIGGER_GUILD tg\r\n                        WHERE tg.Date >= ? AND tg.Date <= ?\r\n                        GROUP BY tg.G_Name\r\n                        ORDER BY " . $order1 . " DESC, " . $order2 . " DESC, " . $order3 . " DESC, " . $order4 . " DESC", [$periodStart, $periodEnd]);
                                } else {
                                    $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tg.G_Name, SUM(tg.G_Score) as G_Score\r\n                        FROM IMPERIAMUCMS_TRIGGER_GUILD tg\r\n                        WHERE tg.Date >= ? AND tg.Date <= ?\r\n                        GROUP BY tg.G_Name\r\n                        ORDER BY G_Score DESC", [$periodStart, $periodEnd]);
                                }
                                $this->giveBadge(2, $data, $periodStart . " - " . $periodEnd, 3, 1);
                            }
                        }
                    }
                }
                if ($ranking == "level") {
                    if ($type == "daily") {
                        $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.AccountID,tc.Name,c.Class,c.cLevel,tc.cLevel as dailycLevel \r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date = ?\r\n                ORDER BY dailycLevel DESC, c.cLevel DESC", [$periodStart]);
                        $this->giveBadge(1, $data, $periodStart, 4, 3);
                        $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "daily_level"]);
                        if (is_array($rewards) && is_array($data)) {
                            $i = 0;
                            foreach ($rewards as $thisReward) {
                                $j = $thisReward["Highest_Rank"];
                                while ($j <= $thisReward["Lowest_Rank"]) {
                                    $arrayIndex = $j - 1;
                                    $userToReward = $data[$arrayIndex];
                                    if (is_array($userToReward)) {
                                        $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_81", true), lang("rankings_txt_1", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                        $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                    }
                                    $j++;
                                }
                                $i++;
                            }
                        }
                    } else {
                        if ($type == "weekly") {
                            $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.AccountID,tc.Name,c.Class,c.cLevel,SUM(tc.cLevel) as weeklycLevel \r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ?  \r\n                GROUP BY tc.AccountID,tc.Name,c.Class,c.cLevel\r\n                ORDER BY weeklycLevel DESC, c.cLevel DESC", [$periodStart, $periodEnd]);
                            $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 4, 2);
                            $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "weekly_level"]);
                            if (is_array($rewards) && is_array($data)) {
                                $i = 0;
                                foreach ($rewards as $thisReward) {
                                    $j = $thisReward["Highest_Rank"];
                                    while ($j <= $thisReward["Lowest_Rank"]) {
                                        $arrayIndex = $j - 1;
                                        $userToReward = $data[$arrayIndex];
                                        if (is_array($userToReward)) {
                                            $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_82", true), lang("rankings_txt_1", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                            $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                        }
                                        $j++;
                                    }
                                    $i++;
                                }
                            }
                        } else {
                            if ($type == "monthly") {
                                $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tc.AccountID,tc.Name,c.Class,c.cLevel,SUM(tc.cLevel) as monthlycLevel \r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.AccountID,tc.Name,c.Class,c.cLevel\r\n                ORDER BY monthlycLevel DESC, c.cLevel DESC", [$periodStart, $periodEnd]);
                                $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 4, 1);
                                $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "monthly_level"]);
                                if (is_array($rewards) && is_array($data)) {
                                    $i = 0;
                                    foreach ($rewards as $thisReward) {
                                        $j = $thisReward["Highest_Rank"];
                                        while ($j <= $thisReward["Lowest_Rank"]) {
                                            $arrayIndex = $j - 1;
                                            $userToReward = $data[$arrayIndex];
                                            if (is_array($userToReward)) {
                                                $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_83", true), lang("rankings_txt_1", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                                $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                            }
                                            $j++;
                                        }
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($ranking == "master") {
                    if ($type == "daily") {
                        $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.AccountID,tc.Name,c.Class,c.mLevel,tc.mLevel as dailymLevel \r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date = ?\r\n                ORDER BY dailymLevel DESC, c.mLevel DESC", [$periodStart]);
                        $this->giveBadge(1, $data, $periodStart, 5, 3);
                        $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "daily_master"]);
                        if (is_array($rewards) && is_array($data)) {
                            $i = 0;
                            foreach ($rewards as $thisReward) {
                                $j = $thisReward["Highest_Rank"];
                                while ($j <= $thisReward["Lowest_Rank"]) {
                                    $arrayIndex = $j - 1;
                                    $userToReward = $data[$arrayIndex];
                                    if (is_array($userToReward)) {
                                        $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_81", true), lang("rankings_txt_22", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                        $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                    }
                                    $j++;
                                }
                                $i++;
                            }
                        }
                    } else {
                        if ($type == "weekly") {
                            $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.AccountID,tc.Name,c.Class,c.mLevel,SUM(tc.mLevel) as weeklymLevel \r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.AccountID,tc.Name,c.Class,c.mLevel\r\n                ORDER BY weeklymLevel DESC, c.mLevel DESC", [$periodStart, $periodEnd]);
                            $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 5, 2);
                            $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "weekly_master"]);
                            if (is_array($rewards) && is_array($data)) {
                                $i = 0;
                                foreach ($rewards as $thisReward) {
                                    $j = $thisReward["Highest_Rank"];
                                    while ($j <= $thisReward["Lowest_Rank"]) {
                                        $arrayIndex = $j - 1;
                                        $userToReward = $data[$arrayIndex];
                                        if (is_array($userToReward)) {
                                            $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_82", true), lang("rankings_txt_22", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                            $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                        }
                                        $j++;
                                    }
                                    $i++;
                                }
                            }
                        } else {
                            if ($type == "monthly") {
                                $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tc.AccountID,tc.Name,c.Class,c.mLevel,SUM(tc.mLevel) as monthlymLevel \r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.AccountID,tc.Name,c.Class,c.mLevel \r\n                ORDER BY monthlymLevel DESC, c.mLevel DESC", [$periodStart, $periodEnd]);
                                $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 5, 1);
                                $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "monthly_master"]);
                                if (is_array($rewards) && is_array($data)) {
                                    $i = 0;
                                    foreach ($rewards as $thisReward) {
                                        $j = $thisReward["Highest_Rank"];
                                        while ($j <= $thisReward["Lowest_Rank"]) {
                                            $arrayIndex = $j - 1;
                                            $userToReward = $data[$arrayIndex];
                                            if (is_array($userToReward)) {
                                                $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_83", true), lang("rankings_txt_22", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                                $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                            }
                                            $j++;
                                        }
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($ranking == "resets") {
                    if ($type == "daily") {
                        $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.AccountID,tc.Name,c.Class,c.RESETS,tc.RESETS as dailyRESETS \r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date = ?\r\n                ORDER BY dailyRESETS DESC, c.RESETS DESC", [$periodStart]);
                        $this->giveBadge(1, $data, $periodStart, 6, 3);
                        $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "daily_resets"]);
                        if (is_array($rewards) && is_array($data)) {
                            $i = 0;
                            foreach ($rewards as $thisReward) {
                                $j = $thisReward["Highest_Rank"];
                                while ($j <= $thisReward["Lowest_Rank"]) {
                                    $arrayIndex = $j - 1;
                                    $userToReward = $data[$arrayIndex];
                                    if (is_array($userToReward)) {
                                        $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_81", true), lang("rankings_txt_2", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                        $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                    }
                                    $j++;
                                }
                                $i++;
                            }
                        }
                    } else {
                        if ($type == "weekly") {
                            $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.AccountID,tc.Name,c.Class,c.RESETS,SUM(tc.RESETS) as weeklyRESETS \r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.AccountID,tc.Name,c.Class,c.RESETS\r\n                ORDER BY weeklyRESETS DESC, c.RESETS DESC", [$periodStart, $periodEnd]);
                            $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 6, 2);
                            $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "weekly_resets"]);
                            if (is_array($rewards) && is_array($data)) {
                                $i = 0;
                                foreach ($rewards as $thisReward) {
                                    $j = $thisReward["Highest_Rank"];
                                    while ($j <= $thisReward["Lowest_Rank"]) {
                                        $arrayIndex = $j - 1;
                                        $userToReward = $data[$arrayIndex];
                                        if (is_array($userToReward)) {
                                            $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_82", true), lang("rankings_txt_2", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                            $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                        }
                                        $j++;
                                    }
                                    $i++;
                                }
                            }
                        } else {
                            if ($type == "monthly") {
                                $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tc.AccountID,tc.Name,c.Class,c.RESETS,SUM(tc.RESETS) as monthlyRESETS \r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.AccountID,tc.Name,c.Class,c.RESETS\r\n                ORDER BY monthlyRESETS DESC, c.RESETS DESC", [$periodStart, $periodEnd]);
                                $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 6, 1);
                                $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "monthly_resets"]);
                                if (is_array($rewards) && is_array($data)) {
                                    $i = 0;
                                    foreach ($rewards as $thisReward) {
                                        $j = $thisReward["Highest_Rank"];
                                        while ($j <= $thisReward["Lowest_Rank"]) {
                                            $arrayIndex = $j - 1;
                                            $userToReward = $data[$arrayIndex];
                                            if (is_array($userToReward)) {
                                                $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_83", true), lang("rankings_txt_2", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                                $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                            }
                                            $j++;
                                        }
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($ranking == "grandresets") {
                    if ($type == "daily") {
                        $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.AccountID,tc.Name,c.Class,c.Grand_Resets,tc.Grand_Resets as dailyGrand_Resets \r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date = ?\r\n                ORDER BY dailyGrand_Resets DESC, c.Grand_Resets DESC", [$periodStart]);
                        $this->giveBadge(1, $data, $periodStart, 7, 3);
                        $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "daily_grandresets"]);
                        if (is_array($rewards) && is_array($data)) {
                            $i = 0;
                            foreach ($rewards as $thisReward) {
                                $j = $thisReward["Highest_Rank"];
                                while ($j <= $thisReward["Lowest_Rank"]) {
                                    $arrayIndex = $j - 1;
                                    $userToReward = $data[$arrayIndex];
                                    if (is_array($userToReward)) {
                                        $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_81", true), lang("rankings_txt_5", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                        $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                    }
                                    $j++;
                                }
                                $i++;
                            }
                        }
                    } else {
                        if ($type == "weekly") {
                            $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.AccountID,tc.Name,c.Class,c.Grand_Resets,SUM(tc.Grand_Resets) as weeklyGrand_Resets \r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.AccountID,tc.Name,c.Class,c.Grand_Resets\r\n                ORDER BY weeklyGrand_Resets DESC, c.Grand_Resets DESC", [$periodStart, $periodEnd]);
                            $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 7, 2);
                            $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "weekly_grandresets"]);
                            if (is_array($rewards) && is_array($data)) {
                                $i = 0;
                                foreach ($rewards as $thisReward) {
                                    $j = $thisReward["Highest_Rank"];
                                    while ($j <= $thisReward["Lowest_Rank"]) {
                                        $arrayIndex = $j - 1;
                                        $userToReward = $data[$arrayIndex];
                                        if (is_array($userToReward)) {
                                            $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_82", true), lang("rankings_txt_5", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                            $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                        }
                                        $j++;
                                    }
                                    $i++;
                                }
                            }
                        } else {
                            if ($type == "monthly") {
                                $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tc.AccountID,tc.Name,c.Class,c.Grand_Resets,SUM(tc.Grand_Resets) as monthlyGrand_Resets \r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                GROUP BY tc.AccountID,tc.Name,c.Class,c.Grand_Resets\r\n                ORDER BY monthlyGrand_Resets DESC, c.Grand_Resets DESC", [$periodStart, $periodEnd]);
                                $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 7, 1);
                                $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "monthly_grandresets"]);
                                if (is_array($rewards) && is_array($data)) {
                                    $i = 0;
                                    foreach ($rewards as $thisReward) {
                                        $j = $thisReward["Highest_Rank"];
                                        while ($j <= $thisReward["Lowest_Rank"]) {
                                            $arrayIndex = $j - 1;
                                            $userToReward = $data[$arrayIndex];
                                            if (is_array($userToReward)) {
                                                $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_83", true), lang("rankings_txt_5", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                                $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                            }
                                            $j++;
                                        }
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($ranking == "killers") {
                    if ($type == "daily") {
                        if (mconfig("rankings_killers_type")) {
                            $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " c.AccountID,c.Name, c.Class, COUNT(pk.Killer) as count\r\n                    FROM C_PlayerKiller_Info pk\r\n                    INNER JOIN Character c ON c.Name = pk.Killer\r\n                    WHERE WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND CAST(pk.KillDate AS DATE) = ?\r\n                    GROUP BY pk.Killer, c.Name, c.Class, m.Country ORDER BY count DESC", [$periodStart]);
                        } else {
                            $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.AccountID,tc.Name,c.Class,tc.PkCount \r\n                    FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                    INNER JOIN Character c ON c.Name = tc.Name\r\n                    WHERE tc.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date = ?\r\n                    ORDER BY tc.PkCount DESC", [$periodStart]);
                        }
                        $this->giveBadge(1, $data, $periodStart, 8, 3);
                        $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "daily_killers"]);
                        if (is_array($rewards) && is_array($data)) {
                            $i = 0;
                            foreach ($rewards as $thisReward) {
                                $j = $thisReward["Highest_Rank"];
                                while ($j <= $thisReward["Lowest_Rank"]) {
                                    $arrayIndex = $j - 1;
                                    $userToReward = $data[$arrayIndex];
                                    if (is_array($userToReward)) {
                                        $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_81", true), lang("rankings_txt_3", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                        $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                    }
                                    $j++;
                                }
                                $i++;
                            }
                        }
                    } else {
                        if ($type == "weekly") {
                            if (mconfig("rankings_killers_type")) {
                                $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " c.AccountID,c.Name, c.Class, COUNT(pk.Killer) as count \r\n                    FROM C_PlayerKiller_Info pk\r\n                    INNER JOIN Character c ON c.Name = pk.Killer\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND  CAST(pk.KillDate AS DATE) >= ? AND CAST(pk.KillDate AS DATE) <= ?\r\n                    GROUP BY c.AccountID, c.Name, c.Class ORDER BY count DESC", [$periodStart, $periodEnd]);
                            } else {
                                $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.AccountID,tc.Name,c.Class,SUM(tc.PkCount) as PkCount\r\n                    FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                    INNER JOIN Character c ON c.Name = tc.Name\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                    GROUP BY tc.AccountID,tc.Name,c.Class \r\n                    ORDER BY PkCount DESC", [$periodStart, $periodEnd]);
                            }
                            $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 8, 2);
                            $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "weekly_killers"]);
                            if (is_array($rewards) && is_array($data)) {
                                $i = 0;
                                foreach ($rewards as $thisReward) {
                                    $j = $thisReward["Highest_Rank"];
                                    while ($j <= $thisReward["Lowest_Rank"]) {
                                        $arrayIndex = $j - 1;
                                        $userToReward = $data[$arrayIndex];
                                        if (is_array($userToReward)) {
                                            $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_82", true), lang("rankings_txt_3", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                            $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                        }
                                        $j++;
                                    }
                                    $i++;
                                }
                            }
                        } else {
                            if ($type == "monthly") {
                                if (mconfig("rankings_killers_type")) {
                                    $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " c.AccountID,c.Name, c.Class, COUNT(pk.Killer) as count\r\n                    FROM C_PlayerKiller_Info pk\r\n                    INNER JOIN Character c ON c.Name = pk.Killer\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND CAST(pk.KillDate AS DATE) >= ? AND CAST(pk.KillDate AS DATE) <= ?\r\n                    GROUP BY c.AccountID, c.Name, c.Class ORDER BY count DESC", [$periodStart, $periodEnd]);
                                } else {
                                    $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tc.AccountID,tc.Name,c.Class,SUM(tc.PkCount) as PkCount\r\n                    FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                    INNER JOIN Character c ON c.Name = tc.Name\r\n                    WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ? \r\n                    GROUP BY tc.AccountID,tc.Name,c.Class\r\n                    ORDER BY PkCount DESC", [$periodStart, $periodEnd]);
                                }
                                $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 8, 1);
                                $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "monthly_killers"]);
                                if (is_array($rewards) && is_array($data)) {
                                    $i = 0;
                                    foreach ($rewards as $thisReward) {
                                        $j = $thisReward["Highest_Rank"];
                                        while ($j <= $thisReward["Lowest_Rank"]) {
                                            $arrayIndex = $j - 1;
                                            $userToReward = $data[$arrayIndex];
                                            if (is_array($userToReward)) {
                                                $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_83", true), lang("rankings_txt_3", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                                $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                            }
                                            $j++;
                                        }
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($ranking == "duels") {
                    if ($type == "daily") {
                        $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " tc.AccountID,tc.Name,c.Class,tc.WinDuels,tc.LoseDuels \r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date = ?\r\n                ORDER BY tc.WinDuels DESC, tc.LoseDuels ASC", [$periodStart]);
                        $this->giveBadge(1, $data, $periodStart, 9, 3);
                        $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "daily_duels"]);
                        if (is_array($rewards) && is_array($data)) {
                            $i = 0;
                            foreach ($rewards as $thisReward) {
                                $j = $thisReward["Highest_Rank"];
                                while ($j <= $thisReward["Lowest_Rank"]) {
                                    $arrayIndex = $j - 1;
                                    $userToReward = $data[$arrayIndex];
                                    if (is_array($userToReward)) {
                                        $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_81", true), lang("rankings_txt_56", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                        $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                    }
                                    $j++;
                                }
                                $i++;
                            }
                        }
                    } else {
                        if ($type == "weekly") {
                            $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " tc.AccountID,tc.Name,c.Class,SUM(tc.WinDuels) as WinDuels,SUM(tc.LoseDuels) as LoseDuels\r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ?  \r\n                GROUP BY tc.AccountID,tc.Name,c.Class\r\n                ORDER BY WinDuels DESC, LoseDuels ASC", [$periodStart, $periodEnd]);
                            $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 9, 2);
                            $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "weekly_duels"]);
                            if (is_array($rewards) && is_array($data)) {
                                $i = 0;
                                foreach ($rewards as $thisReward) {
                                    $j = $thisReward["Highest_Rank"];
                                    while ($j <= $thisReward["Lowest_Rank"]) {
                                        $arrayIndex = $j - 1;
                                        $userToReward = $data[$arrayIndex];
                                        if (is_array($userToReward)) {
                                            $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_82", true), lang("rankings_txt_56", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                            $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                        }
                                        $j++;
                                    }
                                    $i++;
                                }
                            }
                        } else {
                            if ($type == "monthly") {
                                $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " tc.AccountID,tc.Name,c.Class,SUM(tc.WinDuels) as WinDuels,SUM(tc.LoseDuels) as LoseDuels \r\n                FROM IMPERIAMUCMS_TRIGGER_CHARACTER tc\r\n                INNER JOIN Character c ON c.Name = tc.Name\r\n                WHERE c.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tc.Date >= ? AND tc.Date <= ?  \r\n                GROUP BY tc.AccountID,tc.Name,c.Class\r\n                ORDER BY WinDuels DESC, LoseDuels ASC", [$periodStart, $periodEnd]);
                                $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 9, 1);
                                $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "monthly_duels"]);
                                if (is_array($rewards) && is_array($data)) {
                                    $i = 0;
                                    foreach ($rewards as $thisReward) {
                                        $j = $thisReward["Highest_Rank"];
                                        while ($j <= $thisReward["Lowest_Rank"]) {
                                            $arrayIndex = $j - 1;
                                            $userToReward = $data[$arrayIndex];
                                            if (is_array($userToReward)) {
                                                $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_83", true), lang("rankings_txt_56", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                                $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                            }
                                            $j++;
                                        }
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($ranking == "votes" && $type == "monthly") {
                    $data = $dB->query_fetch("\r\n                    SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " COUNT(*) as total, mi.memb___id as AccountID \r\n                    FROM IMPERIAMUCMS_VOTES v\r\n                    INNER JOIN " . $memb_info . " mi ON mi.memb_guid = v.user_id\r\n                    WHERE confirm = '1' AND timestamp >= ? AND timestamp <= ?\r\n                    GROUP BY mi.memb___id \r\n                    ORDER BY total DESC", [strtotime($periodStart), strtotime($periodEnd)]);
                    $this->giveBadge(3, $data, $periodStart . " - " . $periodEnd, 10, 1);
                }
                if ($ranking == "bloodcastle") {
                    if ($type == "daily") {
                        $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " te.AccountID,te.Name,c.Class,te.BC_Points as Point \r\n                FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date = ?\r\n                ORDER BY Point DESC", [$periodStart]);
                        $this->giveBadge(1, $data, $periodStart, 12, 3);
                        $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "daily_bloodcastle"]);
                        if (is_array($rewards) && is_array($data)) {
                            $i = 0;
                            foreach ($rewards as $thisReward) {
                                $j = $thisReward["Highest_Rank"];
                                while ($j <= $thisReward["Lowest_Rank"]) {
                                    $arrayIndex = $j - 1;
                                    $userToReward = $data[$arrayIndex];
                                    if (is_array($userToReward)) {
                                        $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_81", true), lang("rankings_txt_59", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                        $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                    }
                                    $j++;
                                }
                                $i++;
                            }
                        }
                    } else {
                        if ($type == "weekly") {
                            $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " te.AccountID,te.Name,c.Class,SUM(te.BC_Points) as Point \r\n                FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.AccountID,te.Name,c.Class\r\n                ORDER BY Point DESC", [$periodStart, $periodEnd]);
                            $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 12, 2);
                            $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "weekly_bloodcastle"]);
                            if (is_array($rewards) && is_array($data)) {
                                $i = 0;
                                foreach ($rewards as $thisReward) {
                                    $j = $thisReward["Highest_Rank"];
                                    while ($j <= $thisReward["Lowest_Rank"]) {
                                        $arrayIndex = $j - 1;
                                        $userToReward = $data[$arrayIndex];
                                        if (is_array($userToReward)) {
                                            $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_82", true), lang("rankings_txt_59", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                            $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                        }
                                        $j++;
                                    }
                                    $i++;
                                }
                            }
                        } else {
                            if ($type == "monthly") {
                                $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " te.AccountID,te.Name,c.Class,SUM(te.BC_Points) as Point\r\n                FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.AccountID,te.Name,c.Class \r\n                ORDER BY Point DESC", [$periodStart, $periodEnd]);
                                $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 12, 1);
                                $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "monthly_bloodcastle"]);
                                if (is_array($rewards) && is_array($data)) {
                                    $i = 0;
                                    foreach ($rewards as $thisReward) {
                                        $j = $thisReward["Highest_Rank"];
                                        while ($j <= $thisReward["Lowest_Rank"]) {
                                            $arrayIndex = $j - 1;
                                            $userToReward = $data[$arrayIndex];
                                            if (is_array($userToReward)) {
                                                $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_83", true), lang("rankings_txt_59", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                                $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                            }
                                            $j++;
                                        }
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($ranking == "devilsquare") {
                    if ($type == "daily") {
                        $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " te.AccountID,te.Name,c.Class,te.DS_Points as Point\r\n                FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date = ?\r\n                ORDER BY Point DESC", [$periodStart]);
                        $this->giveBadge(1, $data, $periodStart, 11, 3);
                        $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "daily_devilsquare"]);
                        if (is_array($rewards) && is_array($data)) {
                            $i = 0;
                            foreach ($rewards as $thisReward) {
                                $j = $thisReward["Highest_Rank"];
                                while ($j <= $thisReward["Lowest_Rank"]) {
                                    $arrayIndex = $j - 1;
                                    $userToReward = $data[$arrayIndex];
                                    if (is_array($userToReward)) {
                                        $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_81", true), lang("rankings_txt_58", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                        $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                    }
                                    $j++;
                                }
                                $i++;
                            }
                        }
                    } else {
                        if ($type == "weekly") {
                            $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " te.AccountID,te.Name,c.Class,SUM(te.DS_Points) as Point\r\n                FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.AccountID,te.Name,c.Class\r\n                ORDER BY Point DESC", [$periodStart, $periodEnd]);
                            $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 11, 2);
                            $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "weekly_devilsquare"]);
                            if (is_array($rewards) && is_array($data)) {
                                $i = 0;
                                foreach ($rewards as $thisReward) {
                                    $j = $thisReward["Highest_Rank"];
                                    while ($j <= $thisReward["Lowest_Rank"]) {
                                        $arrayIndex = $j - 1;
                                        $userToReward = $data[$arrayIndex];
                                        if (is_array($userToReward)) {
                                            $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_82", true), lang("rankings_txt_58", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                            $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                        }
                                        $j++;
                                    }
                                    $i++;
                                }
                            }
                        } else {
                            if ($type == "monthly") {
                                $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " te.AccountID,te.Name,c.Class,SUM(te.DS_Points) as Point \r\n                FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.AccountID,te.Name,c.Class\r\n                ORDER BY Point DESC", [$periodStart, $periodEnd]);
                                $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 11, 1);
                                $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "monthly_devilsquare"]);
                                if (is_array($rewards) && is_array($data)) {
                                    $i = 0;
                                    foreach ($rewards as $thisReward) {
                                        $j = $thisReward["Highest_Rank"];
                                        while ($j <= $thisReward["Lowest_Rank"]) {
                                            $arrayIndex = $j - 1;
                                            $userToReward = $data[$arrayIndex];
                                            if (is_array($userToReward)) {
                                                $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_83", true), lang("rankings_txt_58", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                                $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                            }
                                            $j++;
                                        }
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($ranking == "chaoscastle") {
                    if ($type == "daily") {
                        $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " te.AccountID,te.Name,c.Class,te.CC_Wins,te.CC_PKillCount,te.CC_MKillCount \r\n                FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date = ?\r\n                ORDER BY te.CC_Wins DESC, te.CC_PKillCount DESC, te.CC_MKillCount DESC", [$periodStart]);
                        $this->giveBadge(1, $data, $periodStart, 13, 3);
                        $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "daily_chaoscastle"]);
                        if (is_array($rewards) && is_array($data)) {
                            $i = 0;
                            foreach ($rewards as $thisReward) {
                                $j = $thisReward["Highest_Rank"];
                                while ($j <= $thisReward["Lowest_Rank"]) {
                                    $arrayIndex = $j - 1;
                                    $userToReward = $data[$arrayIndex];
                                    if (is_array($userToReward)) {
                                        $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_81", true), lang("rankings_txt_60", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                        $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                    }
                                    $j++;
                                }
                                $i++;
                            }
                        }
                    } else {
                        if ($type == "weekly") {
                            $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " te.AccountID,te.Name,c.Class,SUM(te.CC_Wins) as CC_Wins,SUM(te.CC_PKillCount) as CC_PKillCount,SUM(te.CC_MKillCount) as CC_MKillCount\r\n                FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.AccountID,te.Name,c.Class\r\n                ORDER BY CC_Wins DESC, CC_PKillCount DESC, CC_MKillCount DESC", [$periodStart, $periodEnd]);
                            $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 13, 2);
                            $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "weekly_chaoscastle"]);
                            if (is_array($rewards) && is_array($data)) {
                                $i = 0;
                                foreach ($rewards as $thisReward) {
                                    $j = $thisReward["Highest_Rank"];
                                    while ($j <= $thisReward["Lowest_Rank"]) {
                                        $arrayIndex = $j - 1;
                                        $userToReward = $data[$arrayIndex];
                                        if (is_array($userToReward)) {
                                            $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_82", true), lang("rankings_txt_60", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                            $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                        }
                                        $j++;
                                    }
                                    $i++;
                                }
                            }
                        } else {
                            if ($type == "monthly") {
                                $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " te.AccountID,te.Name,c.Class,SUM(te.CC_Wins) as CC_Wins,SUM(te.CC_PKillCount) as CC_PKillCount,SUM(te.CC_MKillCount) as CC_MKillCount \r\n                FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.AccountID,te.Name,c.Class\r\n                ORDER BY CC_Wins DESC, CC_PKillCount DESC, CC_MKillCount DESC", [$periodStart, $periodEnd]);
                                $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 13, 1);
                                $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "monthly_chaoscastle"]);
                                if (is_array($rewards) && is_array($data)) {
                                    $i = 0;
                                    foreach ($rewards as $thisReward) {
                                        $j = $thisReward["Highest_Rank"];
                                        while ($j <= $thisReward["Lowest_Rank"]) {
                                            $arrayIndex = $j - 1;
                                            $userToReward = $data[$arrayIndex];
                                            if (is_array($userToReward)) {
                                                $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_83", true), lang("rankings_txt_60", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                                $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                            }
                                            $j++;
                                        }
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($ranking == "illusiontemple") {
                    if ($type == "daily") {
                        $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["daily"] . " te.AccountID,te.Name,c.Class,te.IT_TotalScore,te.IT_Wins,te.IT_RelicsGivenCount,te.IT_KillCount\r\n                FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date = ?\r\n                ORDER BY te.IT_TotalScore DESC, te.IT_Wins DESC, te.IT_RelicsGivenCount DESC, te.IT_KillCount DESC", [$periodStart]);
                        $this->giveBadge(1, $data, $periodStart, 14, 3);
                        $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "daily_illusiontemple"]);
                        if (is_array($rewards) && is_array($data)) {
                            $i = 0;
                            foreach ($rewards as $thisReward) {
                                $j = $thisReward["Highest_Rank"];
                                while ($j <= $thisReward["Lowest_Rank"]) {
                                    $arrayIndex = $j - 1;
                                    $userToReward = $data[$arrayIndex];
                                    if (is_array($userToReward)) {
                                        $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_81", true), lang("rankings_txt_61", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                        $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                    }
                                    $j++;
                                }
                                $i++;
                            }
                        }
                    } else {
                        if ($type == "weekly") {
                            $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["weekly"] . " te.AccountID,te.Name,c.Class,SUM(te.IT_TotalScore) as IT_TotalScore,SUM(te.IT_Wins) as IT_Wins,SUM(te.IT_RelicsGivenCount) as IT_RelicsGivenCount,SUM(te.IT_KillCount) as IT_KillCount\r\n                FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.AccountID,te.Name,c.Class\r\n                ORDER BY IT_TotalScore DESC, IT_Wins DESC, IT_RelicsGivenCount DESC, IT_KillCount DESC", [$periodStart, $periodEnd]);
                            $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 14, 2);
                            $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "weekly_illusiontemple"]);
                            if (is_array($rewards) && is_array($data)) {
                                $i = 0;
                                foreach ($rewards as $thisReward) {
                                    $j = $thisReward["Highest_Rank"];
                                    while ($j <= $thisReward["Lowest_Rank"]) {
                                        $arrayIndex = $j - 1;
                                        $userToReward = $data[$arrayIndex];
                                        if (is_array($userToReward)) {
                                            $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_82", true), lang("rankings_txt_61", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                            $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                        }
                                        $j++;
                                    }
                                    $i++;
                                }
                            }
                        } else {
                            if ($type == "monthly") {
                                $data = $dB->query_fetch("SELECT TOP " . mconfig("rankings_results")["@attributes"]["monthly"] . " te.AccountID,te.Name,c.Class,SUM(te.IT_TotalScore) as IT_TotalScore,SUM(te.IT_Wins) as IT_Wins,SUM(te.IT_RelicsGivenCount) as IT_RelicsGivenCount,SUM(te.IT_KillCount) as IT_KillCount\r\n                FROM IMPERIAMUCMS_TRIGGER_EVENT te\r\n                LEFT JOIN Character c ON c.Name = te.Name\r\n                WHERE te.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND te.Date >= ? AND te.Date <= ? \r\n                GROUP BY te.AccountID,te.Name,c.Class\r\n                ORDER BY IT_TotalScore DESC, IT_Wins DESC, IT_RelicsGivenCount DESC, IT_KillCount DESC", [$periodStart, $periodEnd]);
                                $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, 14, 1);
                                $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "monthly_illusiontemple"]);
                                if (is_array($rewards) && is_array($data)) {
                                    $i = 0;
                                    foreach ($rewards as $thisReward) {
                                        $j = $thisReward["Highest_Rank"];
                                        while ($j <= $thisReward["Lowest_Rank"]) {
                                            $arrayIndex = $j - 1;
                                            $userToReward = $data[$arrayIndex];
                                            if (is_array($userToReward)) {
                                                $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_83", true), lang("rankings_txt_61", true), $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                                $dB->query("\r\n                                INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS \r\n                                (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                            }
                                            $j++;
                                        }
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($ranking == "monster_hunter") {
                    $rankingsCfg = loadConfigurations("rankings");
                    if ($monster == "all") {
                        $monsterResults = "all";
                        $badgeType = 2;
                        $rewardTitle = sprintf(lang("rankings_txt_96", true), lang("rankings_txt_97", true));
                        $badgeMonster = NULL;
                    } else {
                        $monsterResults = "monsters";
                        $badgeType = 15;
                        $rewardTitle = sprintf(lang("rankings_txt_96", true), lang("monster_" . $monster, true));
                        $badgeMonster = $monster;
                    }
                    if ($type == "daily") {
                        if ($monster == "all") {
                            $data = $dB->query_fetch("SELECT TOP " . $rankingsCfg["rankings_monster_hunter_results_" . $monsterResults] . " tm.AccountID, tm.Name, SUM(tm.Count) as count\r\n                        FROM IMPERIAMUCMS_TRIGGER_MONSTER tm\r\n                        LEFT JOIN Character c ON c.Name = tm.Name\r\n                        WHERE tm.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tm.Date = ?\r\n                        GROUP BY tm.AccountID, tm.Name\r\n                        ORDER BY count DESC", [$periodStart]);
                        } else {
                            $data = $dB->query_fetch("SELECT TOP " . $rankingsCfg["rankings_monster_hunter_results_" . $monsterResults] . " tm.AccountID, tm.Name, SUM(tm.Count) as count\r\n                        FROM IMPERIAMUCMS_TRIGGER_MONSTER tm\r\n                        LEFT JOIN Character c ON c.Name = tm.Name\r\n                        WHERE tm.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tm.MonsterID = ? AND tm.Date = ?\r\n                        GROUP BY tm.AccountID, tm.Name\r\n                        ORDER BY count DESC", [$monster, $periodStart]);
                        }
                        $this->giveBadge(1, $data, $periodStart, $badgeType, 3, $badgeMonster);
                        $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "daily_monster_hunter_" . $monster]);
                        if (is_array($rewards) && is_array($data)) {
                            $i = 0;
                            foreach ($rewards as $thisReward) {
                                $j = $thisReward["Highest_Rank"];
                                while ($j <= $thisReward["Lowest_Rank"]) {
                                    $arrayIndex = $j - 1;
                                    $userToReward = $data[$arrayIndex];
                                    if (is_array($userToReward)) {
                                        $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_81", true), $rewardTitle, $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                        $dB->query("\r\n                                    INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS\r\n                                    (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking . "_" . $monster, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                    }
                                    $j++;
                                }
                                $i++;
                            }
                        }
                    } else {
                        if ($type == "weekly") {
                            if ($monster == "all") {
                                $data = $dB->query_fetch("SELECT TOP " . $rankingsCfg["rankings_monster_hunter_results_" . $monsterResults] . " tm.AccountID, tm.Name, SUM(tm.Count) as count\r\n                        FROM IMPERIAMUCMS_TRIGGER_MONSTER tm\r\n                        LEFT JOIN Character c ON c.Name = tm.Name\r\n                        WHERE tm.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tm.Date >= ? AND tm.Date <= ?\r\n                        GROUP BY tm.AccountID, tm.Name\r\n                        ORDER BY count DESC", [$periodStart, $periodEnd]);
                            } else {
                                $data = $dB->query_fetch("SELECT TOP " . $rankingsCfg["rankings_monster_hunter_results_" . $monsterResults] . " tm.AccountID, tm.Name, SUM(tm.Count) as count\r\n                        FROM IMPERIAMUCMS_TRIGGER_MONSTER tm\r\n                        LEFT JOIN Character c ON c.Name = tm.Name\r\n                        WHERE tm.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tm.MonsterID = ? AND tm.Date >= ? AND tm.Date <= ?\r\n                        GROUP BY tm.AccountID, tm.Name\r\n                        ORDER BY count DESC", [$monster, $periodStart, $periodEnd]);
                            }
                            $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, $badgeType, 2, $badgeMonster);
                            $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "weekly_monster_hunter_" . $monster]);
                            if (is_array($rewards) && is_array($data)) {
                                $i = 0;
                                foreach ($rewards as $thisReward) {
                                    $j = $thisReward["Highest_Rank"];
                                    while ($j <= $thisReward["Lowest_Rank"]) {
                                        $arrayIndex = $j - 1;
                                        $userToReward = $data[$arrayIndex];
                                        if (is_array($userToReward)) {
                                            $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_82", true), $rewardTitle, $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                            $dB->query("\r\n                                    INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS\r\n                                    (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking . "_" . $monster, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                        }
                                        $j++;
                                    }
                                    $i++;
                                }
                            }
                        } else {
                            if ($type == "monthly") {
                                $data = $dB->query_fetch("SELECT TOP " . $rankingsCfg["rankings_monster_hunter_results_" . $monsterResults] . " tm.AccountID, tm.Name, SUM(tm.Count) as count\r\n                        FROM IMPERIAMUCMS_TRIGGER_MONSTER tm\r\n                        LEFT JOIN Character c ON c.Name = tm.Name\r\n                        WHERE tm.Name NOT IN(" . rankingsExcludeChars() . ") AND c.CtlCode = 0 AND tm.Date >= ? AND tm.Date <= ?\r\n                        GROUP BY tm.AccountID, tm.Name\r\n                        ORDER BY count DESC", [$periodStart, $periodEnd]);
                                $this->giveBadge(1, $data, $periodStart . " - " . $periodEnd, $badgeType, 1, $badgeMonster);
                                $rewards = $dB->query_fetch("SELECT TypeID, Type, Type_Text, Highest_Rank, Lowest_Rank, Reward_Items, \r\n                    Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration, Active\r\n                    FROM IMPERIAMUCMS_RANKINGS_REWARDS\r\n                    WHERE Active = ? AND Type = ?", [1, "monthly_monster_hunter_" . $monster]);
                                if (is_array($rewards) && is_array($data)) {
                                    $i = 0;
                                    foreach ($rewards as $thisReward) {
                                        $j = $thisReward["Highest_Rank"];
                                        while ($j <= $thisReward["Lowest_Rank"]) {
                                            $arrayIndex = $j - 1;
                                            $userToReward = $data[$arrayIndex];
                                            if (is_array($userToReward)) {
                                                $dB->query("INSERT INTO IMPERIAMUCMS_CLAIM_REWARD (title, author, AccountID, Name, reward_items, reward_item_type, reward_amount, reward_amount_type, date, expiration, items_expiration, claimed)\r\n                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [sprintf(lang("rankings_txt_88", true), lang("rankings_txt_83", true), $rewardTitle, $j), $adminName, $userToReward["AccountID"], $userToReward["Name"], $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], date("Y-m-d H:i:s", time()), $thisReward["Expiration"], NULL, 0]);
                                                $dB->query("\r\n                                    INSERT INTO IMPERIAMUCMS_RANKINGS_REWARDS_LOGS\r\n                                    (Type, Period_Type, AccountID, Name, Date, Period_Start, Period_End, Rank, Reward_Items, Reward_Items_Type, Reward_Amount, Reward_Amount_Type, Expiration, Items_Expiration)\r\n                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$ranking . "_" . $monster, $type, $userToReward["AccountID"], $userToReward["Name"], date("Y-m-d H:i:s", time()), $periodStart, $periodEnd, $j, $thisReward["Reward_Items"], $thisReward["Reward_Items_Type"], $thisReward["Reward_Amount"], $thisReward["Reward_Amount_Type"], $thisReward["Expiration"], NULL]);
                                            }
                                            $j++;
                                        }
                                        $i++;
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

?>