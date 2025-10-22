<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "\r\n<style>\r\n    .rankings-config-table tbody tr td:first-child {\r\n        width: 30%;\r\n    }\r\n\r\n    .rankings-config-table tbody tr td:last-child {\r\n        width: 70%;\r\n    }\r\n</style>\r\n\r\n<table width=\"100%\" style=\"margin-bottom: 12px;\">\r\n    <tr>\r\n        <td><h2>Rankings Settings</h2></td>\r\n        <td align=\"right\">\r\n            <a href=\"";
echo admincp_base("modules_manager&config=rankings_rewards");
echo "\" class=\"btn btn-primary\">Manage Rewards</a>&nbsp;\r\n            <a href=\"";
echo admincp_base("modules_manager&config=monster_hunter");
echo "\" class=\"btn btn-primary\">Monster Hunter</a>\r\n        </td>\r\n    </tr>\r\n</table>\r\n\r\n";
$General = new xGeneral();
if (check_value($_POST["submit_changes"])) {
    savechanges();
}
loadModuleConfigs("rankings");
echo "\r\n<form action=\"\" method=\"post\">\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Status<br/><span>Enable/disable the ranking system.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_1", mconfig("active"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Rankings Results<br/><span>Amount of ranking results ImperiaMuCMS should cache.</span></th>\r\n            <td>\r\n                <table width=\"100%\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td><input class=\"form-control\" type=\"text\" name=\"setting_2\" value=\"";
echo mconfig("rankings_results")["@attributes"]["general"];
echo "\"/></td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td><input class=\"form-control\" type=\"text\" name=\"results_monthly\" value=\"";
echo mconfig("rankings_results")["@attributes"]["monthly"];
echo "\"/></td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td><input class=\"form-control\" type=\"text\" name=\"results_weekly\" value=\"";
echo mconfig("rankings_results")["@attributes"]["weekly"];
echo "\"/></td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td><input class=\"form-control\" type=\"text\" name=\"results_daily\" value=\"";
echo mconfig("rankings_results")["@attributes"]["daily"];
echo "\"/></td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Active Characters<br/><span>Show only active characters from last X days - Yes/No.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_57", mconfig("rankings_only_active"), "Yes", "No");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Active Days<br/><span>Enter amount of days to specify inactive characters.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_58\" value=\"";
echo mconfig("rankings_active_days");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Week Start<br/><span>Select if your week starts on Monday or Sunday.</span></th>\r\n            <td>\r\n                <select name=\"rankings_week_start\" class=\"form-control\">\r\n                    ";
if (mconfig("rankings_week_start") == "monday" || mconfig("rankings_week_start") != "sunday") {
    echo "<option value=\"monday\" selected=\"selected\">Monday</option>";
} else {
    echo "<option value=\"monday\">Monday</option>";
}
if (mconfig("rankings_week_start") == "sunday") {
    echo "<option value=\"sunday\" selected=\"selected\">Sunday</option>";
} else {
    echo "<option value=\"sunday\">Sunday</option>";
}
echo "                </select>\r\n                <!--<input class=\"form-control\" type=\"text\" name=\"rankings_week_start\" value=\"";
echo mconfig("rankings_week_start");
echo "\"/>-->\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Display Last Update Date<br/><span>Show at the bottom of the rankings the date each ranking was last updated.</span>\r\n            </th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_3", mconfig("rankings_show_date"), "Yes", "No");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Default Rankings<br/><span>Which rankings will be shown by default when accessing to the rankings page.</span></th>\r\n            <td>\r\n                <select name=\"setting_4\" class=\"form-control\">\r\n                    ";
if (mconfig("rankings_show_default") == "achievements") {
    echo "<option value=\"achievements\" selected=\"selected\">Achievements</option>";
} else {
    echo "<option value=\"achievements\">Achievements</option>";
}
if (mconfig("rankings_show_default") == "bloodcastle") {
    echo "<option value=\"bloodcastle\" selected=\"selected\">Blood Castle</option>";
} else {
    echo "<option value=\"bloodcastle\">Blood Castle</option>";
}
if (mconfig("rankings_show_default") == "chaoscastle") {
    echo "<option value=\"chaoscastle\" selected=\"selected\">Chaos Castle</option>";
} else {
    echo "<option value=\"chaoscastle\">Chaos Castle</option>";
}
if (mconfig("rankings_show_default") == "characters") {
    echo "<option value=\"characters\" selected=\"selected\">Characters</option>";
} else {
    echo "<option value=\"characters\">Characters</option>";
}
if (mconfig("rankings_show_default") == "cshistory") {
    echo "<option value=\"cshistory\" selected=\"selected\">Castle Siege History</option>";
} else {
    echo "<option value=\"cshistory\">Castle Siege History</option>";
}
if (mconfig("rankings_show_default") == "devilsquare") {
    echo "<option value=\"devilsquare\" selected=\"selected\">Devil Square</option>";
} else {
    echo "<option value=\"devilsquare\">Devil Square</option>";
}
if (mconfig("rankings_show_default") == "duels") {
    echo "<option value=\"duels\" selected=\"selected\">Duels</option>";
} else {
    echo "<option value=\"duels\">Duels</option>";
}
if (mconfig("rankings_show_default") == "gens") {
    echo "<option value=\"gens\" selected=\"selected\">Gens</option>";
} else {
    echo "<option value=\"gens\">Gens</option>";
}
if (mconfig("rankings_show_default") == "grandresets") {
    echo "<option value=\"grandresets\" selected=\"selected\">Grand Resets</option>";
} else {
    echo "<option value=\"grandresets\">Grand Resets</option>";
}
if (mconfig("rankings_show_default") == "guilds") {
    echo "<option value=\"guilds\" selected=\"selected\">Guilds</option>";
} else {
    echo "<option value=\"guilds\">Guilds</option>";
}
if (mconfig("rankings_show_default") == "honor") {
    echo "<option value=\"honor\" selected=\"selected\">Honor</option>";
} else {
    echo "<option value=\"honor\">Honor</option>";
}
if (mconfig("rankings_show_default") == "illusiontemple") {
    echo "<option value=\"illusiontemple\" selected=\"selected\">Illusion Temple</option>";
} else {
    echo "<option value=\"illusiontemple\">Illusion Temple</option>";
}
if (mconfig("rankings_show_default") == "killers") {
    echo "<option value=\"killers\" selected=\"selected\">Killers</option>";
} else {
    echo "<option value=\"killers\">Killers</option>";
}
if (mconfig("rankings_show_default") == "level") {
    echo "<option value=\"level\" selected=\"selected\">Levels</option>";
} else {
    echo "<option value=\"level\">Levels</option>";
}
if (mconfig("rankings_show_default") == "married") {
    echo "<option value=\"married\" selected=\"selected\">Married</option>";
} else {
    echo "<option value=\"married\">Married</option>";
}
if (mconfig("rankings_show_default") == "master") {
    echo "<option value=\"master\" selected=\"selected\">Master Levels</option>";
} else {
    echo "<option value=\"master\">Master Levels</option>";
}
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("mulords")) {
    if (mconfig("rankings_show_default") == "mulords") {
        echo "<option value=\"mulords\" selected=\"selected\">MU Lords</option>";
    } else {
        echo "<option value=\"mulords\">MU Lords</option>";
    }
}
if (mconfig("rankings_show_default") == "online") {
    echo "<option value=\"online\" selected=\"selected\">Online Time</option>";
} else {
    echo "<option value=\"online\">Online Time</option>";
}
if (mconfig("rankings_show_default") == "onlineplayers") {
    echo "<option value=\"onlineplayers\" selected=\"selected\">Online Players</option>";
} else {
    echo "<option value=\"onlineplayers\">Online Players</option>";
}
if (mconfig("rankings_show_default") == "pvplaststand") {
    echo "<option value=\"pvplaststand\" selected=\"selected\">PvP Last Man Standing</option>";
} else {
    echo "<option value=\"pvplaststand\">Characters</option>";
}
if (mconfig("rankings_show_default") == "resets") {
    echo "<option value=\"resets\" selected=\"selected\">Resets</option>";
} else {
    echo "<option value=\"resets\">Resets</option>";
}
if (mconfig("rankings_show_default") == "score") {
    echo "<option value=\"score\" selected=\"selected\">Score</option>";
} else {
    echo "<option value=\"score\">Score</option>";
}
if (mconfig("rankings_show_default") == "votes") {
    echo "<option value=\"votes\" selected=\"selected\">Votes</option>";
} else {
    echo "<option value=\"votes\">Votes</option>";
}
echo "                </select>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Display Position Number<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_5", mconfig("rankings_show_place_number"), "Yes", "No");
echo "            </td>\r\n        </tr>\r\n\r\n        <tr>\r\n            <th>Order Priority<br/><span>Order priority is used for rankings: Characters - General/Daily/Weekly/Monthly, Guilds - General/Daily/Weekly/Monthly (Characters progress), Honor</span></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>1:</td>\r\n                        <td>\r\n                            <select name=\"order_priority_1\" class=\"form-control\">\r\n                                ";
if (mconfig("order_priority_1") == "cLevel") {
    echo "<option value=\"cLevel\" selected=\"selected\">Levels</option>";
} else {
    echo "<option value=\"cLevel\">Levels</option>";
}
if (mconfig("order_priority_1") == "mLevel") {
    echo "<option value=\"mLevel\" selected=\"selected\">Master Levels</option>";
} else {
    echo "<option value=\"mLevel\">Master Levels</option>";
}
if (mconfig("order_priority_1") == "RESETS") {
    echo "<option value=\"RESETS\" selected=\"selected\">Resets</option>";
} else {
    echo "<option value=\"RESETS\">Resets</option>";
}
if (mconfig("order_priority_1") == "Grand_Resets") {
    echo "<option value=\"Grand_Resets\" selected=\"selected\">Grand Resets</option>";
} else {
    echo "<option value=\"Grand_Resets\">Grand Resets</option>";
}
echo "                            </select>\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>2:</td>\r\n                        <td>\r\n                            <select name=\"order_priority_2\" class=\"form-control\">\r\n                                ";
if (mconfig("order_priority_2") == "cLevel") {
    echo "<option value=\"cLevel\" selected=\"selected\">Levels</option>";
} else {
    echo "<option value=\"cLevel\">Levels</option>";
}
if (mconfig("order_priority_2") == "mLevel") {
    echo "<option value=\"mLevel\" selected=\"selected\">Master Levels</option>";
} else {
    echo "<option value=\"mLevel\">Master Levels</option>";
}
if (mconfig("order_priority_2") == "RESETS") {
    echo "<option value=\"RESETS\" selected=\"selected\">Resets</option>";
} else {
    echo "<option value=\"RESETS\">Resets</option>";
}
if (mconfig("order_priority_2") == "Grand_Resets") {
    echo "<option value=\"Grand_Resets\" selected=\"selected\">Grand Resets</option>";
} else {
    echo "<option value=\"Grand_Resets\">Grand Resets</option>";
}
echo "                            </select>\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>3:</td>\r\n                        <td>\r\n                            <select name=\"order_priority_3\" class=\"form-control\">\r\n                                ";
if (mconfig("order_priority_3") == "cLevel") {
    echo "<option value=\"cLevel\" selected=\"selected\">Levels</option>";
} else {
    echo "<option value=\"cLevel\">Levels</option>";
}
if (mconfig("order_priority_3") == "mLevel") {
    echo "<option value=\"mLevel\" selected=\"selected\">Master Levels</option>";
} else {
    echo "<option value=\"mLevel\">Master Levels</option>";
}
if (mconfig("order_priority_3") == "RESETS") {
    echo "<option value=\"RESETS\" selected=\"selected\">Resets</option>";
} else {
    echo "<option value=\"RESETS\">Resets</option>";
}
if (mconfig("order_priority_3") == "Grand_Resets") {
    echo "<option value=\"Grand_Resets\" selected=\"selected\">Grand Resets</option>";
} else {
    echo "<option value=\"Grand_Resets\">Grand Resets</option>";
}
echo "                            </select>\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>4:</td>\r\n                        <td>\r\n                            <select name=\"order_priority_4\" class=\"form-control\">\r\n                                ";
if (mconfig("order_priority_4") == "cLevel") {
    echo "<option value=\"cLevel\" selected=\"selected\">Levels</option>";
} else {
    echo "<option value=\"cLevel\">Levels</option>";
}
if (mconfig("order_priority_4") == "mLevel") {
    echo "<option value=\"mLevel\" selected=\"selected\">Master Levels</option>";
} else {
    echo "<option value=\"mLevel\">Master Levels</option>";
}
if (mconfig("order_priority_4") == "RESETS") {
    echo "<option value=\"RESETS\" selected=\"selected\">Resets</option>";
} else {
    echo "<option value=\"RESETS\">Resets</option>";
}
if (mconfig("order_priority_4") == "Grand_Resets") {
    echo "<option value=\"Grand_Resets\" selected=\"selected\">Grand Resets</option>";
} else {
    echo "<option value=\"Grand_Resets\">Grand Resets</option>";
}
echo "                            </select>\r\n                        </td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n\r\n        <tr>\r\n            <th>Characters Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_16", mconfig("rankings_enable_characters")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_characters_monthly", mconfig("rankings_enable_characters")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_characters_weekly", mconfig("rankings_enable_characters")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_characters_daily", mconfig("rankings_enable_characters")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Monster Hunter Rankings<br/></th>\r\n            <td>";
enabledisableCheckboxes("rankings_enable_monster_hunter", mconfig("rankings_enable_monster_hunter")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n        </tr>\r\n        <tr>\r\n            <th>Monster Hunter Rankings - Results All<br/><span>Number of results for Monster Hunter Rankings - All</span></th>\r\n            <td><input type=\"text\" name=\"rankings_monster_hunter_results_all\" class=\"form-control\" value=\"";
echo mconfig("rankings_monster_hunter_results_all");
echo "\"/></td>\r\n        </tr>\r\n        <tr>\r\n            <th>Monster Hunter Rankings - Results Monsters<br/><span>Number of results for Monster Hunter Rankings - Specific Monster</span></th>\r\n            <td><input type=\"text\" name=\"rankings_monster_hunter_results_monsters\" class=\"form-control\" value=\"";
echo mconfig("rankings_monster_hunter_results_monsters");
echo "\"/></td>\r\n        </tr>\r\n        <tr>\r\n            <th>Level Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_6", mconfig("rankings_enable_level")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_level_monthly", mconfig("rankings_enable_level")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_level_weekly", mconfig("rankings_enable_level")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_level_daily", mconfig("rankings_enable_level")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Master Level Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_12", mconfig("rankings_enable_master")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_master_monthly", mconfig("rankings_enable_master")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_master_weekly", mconfig("rankings_enable_master")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_master_daily", mconfig("rankings_enable_master")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Reset Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_7", mconfig("rankings_enable_resets")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_resets_monthly", mconfig("rankings_enable_resets")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_resets_weekly", mconfig("rankings_enable_resets")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_resets_daily", mconfig("rankings_enable_resets")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Fastest Reset Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_fast_resets_general", mconfig("rankings_enable_fast_resets")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Grand Reset Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_9", mconfig("rankings_enable_gr")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_gr_monthly", mconfig("rankings_enable_gr")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_gr_weekly", mconfig("rankings_enable_gr")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_gr_daily", mconfig("rankings_enable_gr")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Fastest Grand Reset Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_fast_gresets_general", mconfig("rankings_enable_fast_gresets")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Killer Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_8", mconfig("rankings_enable_pk")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_pk_monthly", mconfig("rankings_enable_pk")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_pk_weekly", mconfig("rankings_enable_pk")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_pk_daily", mconfig("rankings_enable_pk")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td colspan=\"2\">\r\n                            <hr>\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Type:</td>\r\n                        <td>";
enabledisableCheckboxes2("setting_56", mconfig("rankings_killers_type"), "C_PlayerKiller_Info Table", "Character.PKCount");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Duels Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_17", mconfig("rankings_enable_duels")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_duels_monthly", mconfig("rankings_enable_duels")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_duels_weekly", mconfig("rankings_enable_duels")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_duels_daily", mconfig("rankings_enable_duels")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Gens Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_14", mconfig("rankings_enable_gens")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <!--<tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_gens_monthly", mconfig("rankings_enable_gens")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_gens_weekly", mconfig("rankings_enable_gens")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_gens_daily", mconfig("rankings_enable_gens")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>-->\r\n                    <tr>\r\n                        <td colspan=\"2\">\r\n                            <hr>\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Statistics:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_26", mconfig("rankings_gens_stat"), "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Guild Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_11", mconfig("rankings_enable_guilds")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_guilds_monthly", mconfig("rankings_enable_guilds")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_guilds_weekly", mconfig("rankings_enable_guilds")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_guilds_daily", mconfig("rankings_enable_guilds")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td colspan=\"2\">\r\n                            <hr>\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Order By:</td>\r\n                        <td>";
enabledisableCheckboxes2("setting_24", mconfig("rankings_guild_type"), "Characters progression", "Guild Score");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Online Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_10", mconfig("rankings_enable_online")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <!--<tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_online_monthly", mconfig("rankings_enable_online")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_online_weekly", mconfig("rankings_enable_online")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_online_daily", mconfig("rankings_enable_online")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>-->\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Vote Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_15", mconfig("rankings_enable_votes")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_votes_monthly", mconfig("rankings_enable_votes")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <!--<tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_votes_weekly", mconfig("rankings_enable_votes")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_votes_daily", mconfig("rankings_enable_votes")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td colspan=\"2\"><hr></td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Type:</td>\r\n                        <td>";
enabledisableCheckboxes2("setting_30", mconfig("rankings_votes_type"), "Total Votes", "This Month Votes");
echo "</td>\r\n                    </tr>-->\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Online Players Rankings<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_23", mconfig("rankings_enable_online_players")["@attributes"]["general"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>AFK Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_65", mconfig("rankings_enable_afk")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <!--<tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_afk_monthly", mconfig("rankings_enable_afk")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_afk_weekly", mconfig("rankings_enable_afk")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_afk_daily", mconfig("rankings_enable_afk")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td colspan=\"2\"><hr></td>\r\n                    </tr>-->\r\n                    <!--<tr>\r\n                        <td>Type:</td>\r\n                        <td>";
enabledisableCheckboxes2("setting_71", mconfig("rankings_afk_type"), "All Time ", "Current Month Only");
echo "</td>\r\n                    </tr>-->\r\n                    <tr>\r\n                        <td colspan=\"2\">\r\n                            <hr>\r\n                        </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Order By:</td>\r\n                        <td>\r\n                            1: <select name=\"setting_66\" class=\"form-control\" style=\"width: 95%; display: inline-block;\">\r\n                                ";
if (mconfig("rankings_afk_order1") == "none") {
    echo "<option value=\"none\" selected=\"selected\">-- None --</option>";
} else {
    echo "<option value=\"none\">-- None --</option>";
}
if (mconfig("rankings_afk_order1") == "TotalTime") {
    echo "<option value=\"TotalTime\" selected=\"selected\">Hunting Time</option>";
} else {
    echo "<option value=\"TotalTime\">Hunting Time</option>";
}
if (mconfig("rankings_afk_order1") == "TotalDmg") {
    echo "<option value=\"TotalDmg\" selected=\"selected\">Damage Deal</option>";
} else {
    echo "<option value=\"TotalDmg\">Damage Deal</option>";
}
if (mconfig("rankings_afk_order1") == "TotalElDmg") {
    echo "<option value=\"TotalElDmg\" selected=\"selected\">Elemental Damage Deal</option>";
} else {
    echo "<option value=\"TotalElDmg\">Elemental Damage Deal</option>";
}
if (mconfig("rankings_afk_order1") == "TotalKills") {
    echo "<option value=\"TotalKills\" selected=\"selected\">Monster Kill Count</option>";
} else {
    echo "<option value=\"TotalKills\">Monster Kill Count</option>";
}
if (mconfig("rankings_afk_order1") == "TotalExp") {
    echo "<option value=\"TotalExp\" selected=\"selected\">Gain Exp</option>";
} else {
    echo "<option value=\"TotalExp\">Gain Exp</option>";
}
echo "                            </select><br/>\r\n                            2: <select name=\"setting_67\" class=\"form-control\" style=\"width: 95%; display: inline-block;\">\r\n                                ";
if (mconfig("rankings_afk_order2") == "none") {
    echo "<option value=\"none\" selected=\"selected\">-- None --</option>";
} else {
    echo "<option value=\"none\">-- None --</option>";
}
if (mconfig("rankings_afk_order2") == "TotalTime") {
    echo "<option value=\"TotalTime\" selected=\"selected\">Hunting Time</option>";
} else {
    echo "<option value=\"TotalTime\">Hunting Time</option>";
}
if (mconfig("rankings_afk_order2") == "TotalDmg") {
    echo "<option value=\"TotalDmg\" selected=\"selected\">Damage Deal</option>";
} else {
    echo "<option value=\"TotalDmg\">Damage Deal</option>";
}
if (mconfig("rankings_afk_order2") == "TotalElDmg") {
    echo "<option value=\"TotalElDmg\" selected=\"selected\">Elemental Damage Deal</option>";
} else {
    echo "<option value=\"TotalElDmg\">Elemental Damage Deal</option>";
}
if (mconfig("rankings_afk_order2") == "TotalKills") {
    echo "<option value=\"TotalKills\" selected=\"selected\">Monster Kill Count</option>";
} else {
    echo "<option value=\"TotalKills\">Monster Kill Count</option>";
}
if (mconfig("rankings_afk_order2") == "TotalExp") {
    echo "<option value=\"TotalExp\" selected=\"selected\">Gain Exp</option>";
} else {
    echo "<option value=\"TotalExp\">Gain Exp</option>";
}
echo "                            </select><br/>\r\n                            3: <select name=\"setting_68\" class=\"form-control\" style=\"width: 95%; display: inline-block;\">\r\n                                ";
if (mconfig("rankings_afk_order3") == "none") {
    echo "<option value=\"none\" selected=\"selected\">-- None --</option>";
} else {
    echo "<option value=\"none\">-- None --</option>";
}
if (mconfig("rankings_afk_order3") == "TotalTime") {
    echo "<option value=\"TotalTime\" selected=\"selected\">Hunting Time</option>";
} else {
    echo "<option value=\"TotalTime\">Hunting Time</option>";
}
if (mconfig("rankings_afk_order3") == "TotalDmg") {
    echo "<option value=\"TotalDmg\" selected=\"selected\">Damage Deal</option>";
} else {
    echo "<option value=\"TotalDmg\">Damage Deal</option>";
}
if (mconfig("rankings_afk_order3") == "TotalElDmg") {
    echo "<option value=\"TotalElDmg\" selected=\"selected\">Elemental Damage Deal</option>";
} else {
    echo "<option value=\"TotalElDmg\">Elemental Damage Deal</option>";
}
if (mconfig("rankings_afk_order3") == "TotalKills") {
    echo "<option value=\"TotalKills\" selected=\"selected\">Monster Kill Count</option>";
} else {
    echo "<option value=\"TotalKills\">Monster Kill Count</option>";
}
if (mconfig("rankings_afk_order3") == "TotalExp") {
    echo "<option value=\"TotalExp\" selected=\"selected\">Gain Exp</option>";
} else {
    echo "<option value=\"TotalExp\">Gain Exp</option>";
}
echo "                            </select><br/>\r\n                            4: <select name=\"setting_69\" class=\"form-control\" style=\"width: 95%; display: inline-block;\">\r\n                                ";
if (mconfig("rankings_afk_order4") == "none") {
    echo "<option value=\"none\" selected=\"selected\">-- None --</option>";
} else {
    echo "<option value=\"none\">-- None --</option>";
}
if (mconfig("rankings_afk_order4") == "TotalTime") {
    echo "<option value=\"TotalTime\" selected=\"selected\">Hunting Time</option>";
} else {
    echo "<option value=\"TotalTime\">Hunting Time</option>";
}
if (mconfig("rankings_afk_order4") == "TotalDmg") {
    echo "<option value=\"TotalDmg\" selected=\"selected\">Damage Deal</option>";
} else {
    echo "<option value=\"TotalDmg\">Damage Deal</option>";
}
if (mconfig("rankings_afk_order4") == "TotalElDmg") {
    echo "<option value=\"TotalElDmg\" selected=\"selected\">Elemental Damage Deal</option>";
} else {
    echo "<option value=\"TotalElDmg\">Elemental Damage Deal</option>";
}
if (mconfig("rankings_afk_order4") == "TotalKills") {
    echo "<option value=\"TotalKills\" selected=\"selected\">Monster Kill Count</option>";
} else {
    echo "<option value=\"TotalKills\">Monster Kill Count</option>";
}
if (mconfig("rankings_afk_order4") == "TotalExp") {
    echo "<option value=\"TotalExp\" selected=\"selected\">Gain Exp</option>";
} else {
    echo "<option value=\"TotalExp\">Gain Exp</option>";
}
echo "                            </select><br/>\r\n                            5: <select name=\"setting_70\" class=\"form-control\" style=\"width: 95%; display: inline-block;\">\r\n                                ";
if (mconfig("rankings_afk_order5") == "none") {
    echo "<option value=\"none\" selected=\"selected\">-- None --</option>";
} else {
    echo "<option value=\"none\">-- None --</option>";
}
if (mconfig("rankings_afk_order5") == "TotalTime") {
    echo "<option value=\"TotalTime\" selected=\"selected\">Hunting Time</option>";
} else {
    echo "<option value=\"TotalTime\">Hunting Time</option>";
}
if (mconfig("rankings_afk_order5") == "TotalDmg") {
    echo "<option value=\"TotalDmg\" selected=\"selected\">Damage Deal</option>";
} else {
    echo "<option value=\"TotalDmg\">Damage Deal</option>";
}
if (mconfig("rankings_afk_order5") == "TotalElDmg") {
    echo "<option value=\"TotalElDmg\" selected=\"selected\">Elemental Damage Deal</option>";
} else {
    echo "<option value=\"TotalElDmg\">Elemental Damage Deal</option>";
}
if (mconfig("rankings_afk_order5") == "TotalKills") {
    echo "<option value=\"TotalKills\" selected=\"selected\">Monster Kill Count</option>";
} else {
    echo "<option value=\"TotalKills\">Monster Kill Count</option>";
}
if (mconfig("rankings_afk_order5") == "TotalExp") {
    echo "<option value=\"TotalExp\" selected=\"selected\">Gain Exp</option>";
} else {
    echo "<option value=\"TotalExp\">Gain Exp</option>";
}
echo "                            </select>\r\n                        </td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n\r\n        <tr>\r\n            <th>Characters Score Rankings<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_40", mconfig("rankings_enable_score")["@attributes"]["general"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Honor Rankings<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_59", mconfig("rankings_enable_honor")["@attributes"]["general"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Achievements Rankings<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_25", mconfig("rankings_enable_achievements")["@attributes"]["general"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Marriage Rankings<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_27", mconfig("rankings_enable_married")["@attributes"]["general"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <!--<tr>\r\n            <th>PvP Last Stand Rankings<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_13", mconfig("rankings_enable_pvplaststand")["@attributes"]["general"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>-->\r\n\r\n        <tr>\r\n            <th>Devil Square Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_18", mconfig("rankings_enable_devilsquare")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_devilsquare_monthly", mconfig("rankings_enable_devilsquare")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_devilsquare_weekly", mconfig("rankings_enable_devilsquare")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_devilsquare_daily", mconfig("rankings_enable_devilsquare")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Blood Castle Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_19", mconfig("rankings_enable_bloodcastle")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_bloodcastle_monthly", mconfig("rankings_enable_bloodcastle")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_bloodcastle_weekly", mconfig("rankings_enable_bloodcastle")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_bloodcastle_daily", mconfig("rankings_enable_bloodcastle")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Chaos Castle Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_20", mconfig("rankings_enable_chaoscastle")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_chaoscastle_monthly", mconfig("rankings_enable_chaoscastle")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_chaoscastle_weekly", mconfig("rankings_enable_chaoscastle")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_chaoscastle_daily", mconfig("rankings_enable_chaoscastle")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Illusion Temple Rankings<br/></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>General:</td>\r\n                        <td>";
enabledisableCheckboxes("setting_21", mconfig("rankings_enable_illusiontemple")["@attributes"]["general"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_illusiontemple_monthly", mconfig("rankings_enable_illusiontemple")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_illusiontemple_weekly", mconfig("rankings_enable_illusiontemple")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rankings_enable_illusiontemple_daily", mconfig("rankings_enable_illusiontemple")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Castle Siege History Rankings<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_22", mconfig("rankings_enable_cshistory")["@attributes"]["general"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Arka War History Rankings<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("arkawar_history", mconfig("rankings_enable_arkawar_history")["@attributes"]["general"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Ice Wind Valley History Rankings<br/></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("icewindvalley_history", mconfig("rankings_enable_icewindvalley_history")["@attributes"]["general"], "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n    </table>\r\n\r\n    <hr>\r\n    <h3>Honor Settings</h3>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Minimum Level<br><span>Minimum character's level to show in Honor rankings.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_60\" value=\"";
echo mconfig("honor_level");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Minimum Master Level<br><span>Minimum character's master level to show in Honor rankings.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_61\" value=\"";
echo mconfig("honor_mlevel");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Minimum Reset<br><span>Minimum character's reset to show in Honor rankings.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_62\" value=\"";
echo mconfig("honor_reset");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Minimum Grand Reset<br><span>Minimum character's grand reset to show in Honor rankings.</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_63\" value=\"";
echo mconfig("honor_greset");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Include characters on classic rankings<br/><span>If enabled, characters from Honor rankings will be also displayed on classic Characters rankings.</span></th>\r\n            <td>\r\n                ";
enabledisableCheckboxes("setting_64", mconfig("include_honor_on_char_rankings"), "Enabled", "Disabled");
echo "            </td>\r\n        </tr>\r\n    </table>\r\n\r\n    <hr>\r\n    <h3>Rewards Settings</h3>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Characters Rankings Rewards<br/><span>If disabled, badges won't be added neither.</span></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_characters_daily", mconfig("rewards_characters")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_characters_weekly", mconfig("rewards_characters")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_characters_monthly", mconfig("rewards_characters")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Guilds Rankings Rewards<br/><span>Used only for badges.</span></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_guilds_daily", mconfig("rewards_guilds")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_guilds_weekly", mconfig("rewards_guilds")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_guilds_monthly", mconfig("rewards_guilds")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Levels Rankings Rewards<br/><span>If disabled, badges won't be added neither.</span></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_level_daily", mconfig("rewards_level")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_level_weekly", mconfig("rewards_level")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_level_monthly", mconfig("rewards_level")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Master Level Rankings Rewards<br/><span>If disabled, badges won't be added neither.</span></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_master_daily", mconfig("rewards_master")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_master_weekly", mconfig("rewards_master")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_master_monthly", mconfig("rewards_master")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Resets Rankings Rewards<br/><span>If disabled, badges won't be added neither.</span></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_resets_daily", mconfig("rewards_resets")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_resets_weekly", mconfig("rewards_resets")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_resets_monthly", mconfig("rewards_resets")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Grand Resets Rankings Rewards<br/><span>If disabled, badges won't be added neither.</span></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_grandresets_daily", mconfig("rewards_grandresets")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_grandresets_weekly", mconfig("rewards_grandresets")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_grandresets_monthly", mconfig("rewards_grandresets")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Killers Rankings Rewards<br/><span>If disabled, badges won't be added neither.</span></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_killers_daily", mconfig("rewards_killers")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_killers_weekly", mconfig("rewards_killers")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_killers_monthly", mconfig("rewards_killers")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Duels Rankings Rewards<br/><span>If disabled, badges won't be added neither.</span></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_duels_daily", mconfig("rewards_duels")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_duels_weekly", mconfig("rewards_duels")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_duels_monthly", mconfig("rewards_duels")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Votes Rankings Rewards<br/><span>Used only for badges.</span></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_votes_monthly", mconfig("rewards_votes")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Blood Castle Rankings Rewards<br/><span>If disabled, badges won't be added neither.</span></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_bc_daily", mconfig("rewards_bc")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_bc_weekly", mconfig("rewards_bc")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_bc_monthly", mconfig("rewards_bc")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Devil Square Rankings Rewards<br/><span>If disabled, badges won't be added neither.</span></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_ds_daily", mconfig("rewards_ds")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_ds_weekly", mconfig("rewards_ds")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_ds_monthly", mconfig("rewards_ds")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Chaos Castle Rankings Rewards<br/><span>If disabled, badges won't be added neither.</span></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_cc_daily", mconfig("rewards_cc")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_cc_weekly", mconfig("rewards_cc")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_cc_monthly", mconfig("rewards_cc")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Illusion Temple Rankings Rewards<br/><span>If disabled, badges won't be added neither.</span></th>\r\n            <td>\r\n                <table width=\"100%\" class=\"rankings-config-table\">\r\n                    <tr>\r\n                        <td>Daily:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_it_daily", mconfig("rewards_it")["@attributes"]["daily"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Weekly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_it_weekly", mconfig("rewards_it")["@attributes"]["weekly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>Monthly:</td>\r\n                        <td>";
enabledisableCheckboxes("rewards_it_monthly", mconfig("rewards_it")["@attributes"]["monthly"], "Enabled", "Disabled");
echo "</td>\r\n                    </tr>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n\r\n    <hr>\r\n    <h3>Characters Score Settings<br><small style=\"font-size: 12px\"><b>Total Points</b> = (Level * Significance) + (Master Level * Significance) + (Reset * Significance) + (Grand Reset * Significance)\r\n            + (Stats * Significance)\r\n            + (Achievement Points * Significance) + (Duels Wins * Significance) - (Duels Loses * Significance) + (Significance / Gens Rank) + (Gens Contribution * Significance)\r\n            + (Significance / Gens Class) + (DS Points * Significance) + (BC Points * Significance) + (CC Wins * Significance) + (IT Points * Significance)</small></h3>\r\n    <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n        <tr>\r\n            <th>Level's Significance<br><span>Points for Level = Level * Significance</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_41\" value=\"";
echo mconfig("score_rankings_lvl");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Master Level's Significance<br><span>Points for Master Level = Master Level * Significance</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_42\" value=\"";
echo mconfig("score_rankings_mlvl");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Reset's Significance<br><span>Points for Reset = Reset * Significance</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_43\" value=\"";
echo mconfig("score_rankings_reset");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Grand Reset's Significance<br><span>Points for Grand Reset = Grand Reset * Significance</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_44\" value=\"";
echo mconfig("score_rankings_greset");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Stats's Significance<br><span>Points for Stats = Total Stats * Significance</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_45\" value=\"";
echo mconfig("score_rankings_stats");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Achievements' Significance<br><span>Points for Achievements = Achievement Points * Significance</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_46\" value=\"";
echo mconfig("score_rankings_achiev");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Duel Wins' Significance<br><span>Points for Duel Wins = Wins * Significance</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_47\" value=\"";
echo mconfig("score_rankings_duel_win");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Duel Loses' Significance<br><span>Points for Duel Loses = -(Loses * Significance)</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_48\" value=\"";
echo mconfig("score_rankings_duel_lose");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Gens Rank's Significance<br><span>Points for Gens Rank = Significance / Gens Rank</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_49\" value=\"";
echo mconfig("score_rankings_gens_rank");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Gens Contribution's Significance<br><span>Points for Contribution = Contribution * Significance</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_50\" value=\"";
echo mconfig("score_rankings_gens_points");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Gens Class' Significance<br><span>Points for Gens Class = Significance / Gens Class</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_51\" value=\"";
echo mconfig("score_rankings_gens_class");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Devil Square's Significance<br><span>Points for Devil Square = Points * Significance</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_52\" value=\"";
echo mconfig("score_rankings_ds");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Blood Castle's Significance<br><span>Points for Blood Castle = Points * Significance</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_53\" value=\"";
echo mconfig("score_rankings_bc");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Chaos Castle's Significance<br><span>Points for Chaos Castle = Wins * Significance</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_54\" value=\"";
echo mconfig("score_rankings_cc");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <th>Illusion Temple's Significance<br><span>Points for Illusion Temple = Points * Significance</span></th>\r\n            <td>\r\n                <input class=\"form-control\" type=\"text\" name=\"setting_55\" value=\"";
echo mconfig("score_rankings_it");
echo "\"/>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\r\n</form>";
function saveChanges()
{
    
    global $General;
    foreach ($_POST as $setting) {
        if (!check_value($setting)) {
            message("error", "Missing data (complete all fields).");
            return NULL;
        }
    }
    if ($_POST["setting_66"] == $_POST["setting_67"] || $_POST["setting_66"] == $_POST["setting_68"] || $_POST["setting_66"] == $_POST["setting_69"] || $_POST["setting_66"] == $_POST["setting_70"] || $_POST["setting_67"] == $_POST["setting_68"] || $_POST["setting_67"] == $_POST["setting_69"] || $_POST["setting_67"] == $_POST["setting_70"] || $_POST["setting_68"] == $_POST["setting_69"] || $_POST["setting_68"] == $_POST["setting_70"] || $_POST["setting_69"] == $_POST["setting_70"]) {
        message("error", "Please choose unique order by options for AFK Rankings.");
        return NULL;
    }
    if ($_POST["setting_66"] == "none" || $_POST["setting_67"] == "none" || $_POST["setting_68"] == "none" || $_POST["setting_69"] == "none" || $_POST["setting_70"] == "none") {
        message("error", "Please select all order columns for AFK Rankings.");
        return NULL;
    }
    $xmlPath = __PATH_MODULE_CONFIGS__ . "rankings.xml";
    $xml = simplexml_load_file($xmlPath);
    $xml->active = $_POST["setting_1"];
    if ($xml->rankings_results->attributes()->general != NULL) {
        $xml->rankings_results->attributes()->general = $_POST["setting_2"];
    } else {
        $xml->rankings_results->addAttribute("general", $_POST["setting_2"]);
    }
    if ($xml->rankings_results->attributes()->monthly != NULL) {
        $xml->rankings_results->attributes()->monthly = $_POST["results_monthly"];
    } else {
        $xml->rankings_results->addAttribute("monthly", $_POST["results_monthly"]);
    }
    if ($xml->rankings_results->attributes()->weekly != NULL) {
        $xml->rankings_results->attributes()->weekly = $_POST["results_weekly"];
    } else {
        $xml->rankings_results->addAttribute("weekly", $_POST["results_weekly"]);
    }
    if ($xml->rankings_results->attributes()->daily != NULL) {
        $xml->rankings_results->attributes()->daily = $_POST["results_daily"];
    } else {
        $xml->rankings_results->addAttribute("daily", $_POST["results_daily"]);
    }
    $xml->rankings_only_active = $_POST["setting_57"];
    $xml->rankings_active_days = $_POST["setting_58"];
    $xml->rankings_show_date = $_POST["setting_3"];
    $xml->rankings_show_default = $_POST["setting_4"];
    $xml->rankings_show_place_number = $_POST["setting_5"];
    $xml->order_priority_1 = $_POST["order_priority_1"];
    $xml->order_priority_2 = $_POST["order_priority_2"];
    $xml->order_priority_3 = $_POST["order_priority_3"];
    $xml->order_priority_4 = $_POST["order_priority_4"];
    $xml->rankings_week_start = $_POST["rankings_week_start"];
    if ($xml->rankings_enable_characters->attributes()->general != NULL) {
        $xml->rankings_enable_characters->attributes()->general = $_POST["setting_16"];
    } else {
        $xml->rankings_enable_characters->addAttribute("general", $_POST["setting_16"]);
    }
    if ($xml->rankings_enable_characters->attributes()->monthly != NULL) {
        $xml->rankings_enable_characters->attributes()->monthly = $_POST["rankings_enable_characters_monthly"];
    } else {
        $xml->rankings_enable_characters->addAttribute("monthly", $_POST["rankings_enable_characters_monthly"]);
    }
    if ($xml->rankings_enable_characters->attributes()->weekly != NULL) {
        $xml->rankings_enable_characters->attributes()->weekly = $_POST["rankings_enable_characters_weekly"];
    } else {
        $xml->rankings_enable_characters->addAttribute("weekly", $_POST["rankings_enable_characters_weekly"]);
    }
    if ($xml->rankings_enable_characters->attributes()->daily != NULL) {
        $xml->rankings_enable_characters->attributes()->daily = $_POST["rankings_enable_characters_daily"];
    } else {
        $xml->rankings_enable_characters->addAttribute("daily", $_POST["rankings_enable_characters_daily"]);
    }
    if ($xml->rankings_enable_monster_hunter->attributes()->general != NULL) {
        $xml->rankings_enable_monster_hunter->attributes()->general = $_POST["rankings_enable_monster_hunter"];
    } else {
        $xml->rankings_enable_monster_hunter->addAttribute("general", $_POST["rankings_enable_monster_hunter"]);
    }
    $xml->rankings_monster_hunter_results_all = $_POST["rankings_monster_hunter_results_all"];
    $xml->rankings_monster_hunter_results_monsters = $_POST["rankings_monster_hunter_results_monsters"];
    if ($xml->rankings_enable_level->attributes()->general != NULL) {
        $xml->rankings_enable_level->attributes()->general = $_POST["setting_6"];
    } else {
        $xml->rankings_enable_level->addAttribute("general", $_POST["setting_6"]);
    }
    if ($xml->rankings_enable_level->attributes()->monthly != NULL) {
        $xml->rankings_enable_level->attributes()->monthly = $_POST["rankings_enable_level_monthly"];
    } else {
        $xml->rankings_enable_level->addAttribute("monthly", $_POST["rankings_enable_level_monthly"]);
    }
    if ($xml->rankings_enable_level->attributes()->weekly != NULL) {
        $xml->rankings_enable_level->attributes()->weekly = $_POST["rankings_enable_level_weekly"];
    } else {
        $xml->rankings_enable_level->addAttribute("weekly", $_POST["rankings_enable_level_weekly"]);
    }
    if ($xml->rankings_enable_level->attributes()->daily != NULL) {
        $xml->rankings_enable_level->attributes()->daily = $_POST["rankings_enable_level_daily"];
    } else {
        $xml->rankings_enable_level->addAttribute("daily", $_POST["rankings_enable_level_daily"]);
    }
    if ($xml->rankings_enable_master->attributes()->general != NULL) {
        $xml->rankings_enable_master->attributes()->general = $_POST["setting_12"];
    } else {
        $xml->rankings_enable_master->addAttribute("general", $_POST["setting_12"]);
    }
    if ($xml->rankings_enable_master->attributes()->monthly != NULL) {
        $xml->rankings_enable_master->attributes()->monthly = $_POST["rankings_enable_master_monthly"];
    } else {
        $xml->rankings_enable_master->addAttribute("monthly", $_POST["rankings_enable_master_monthly"]);
    }
    if ($xml->rankings_enable_master->attributes()->weekly != NULL) {
        $xml->rankings_enable_master->attributes()->weekly = $_POST["rankings_enable_master_weekly"];
    } else {
        $xml->rankings_enable_master->addAttribute("weekly", $_POST["rankings_enable_master_weekly"]);
    }
    if ($xml->rankings_enable_master->attributes()->daily != NULL) {
        $xml->rankings_enable_master->attributes()->daily = $_POST["rankings_enable_master_daily"];
    } else {
        $xml->rankings_enable_master->addAttribute("daily", $_POST["rankings_enable_master_daily"]);
    }
    if ($xml->rankings_enable_resets->attributes()->general != NULL) {
        $xml->rankings_enable_resets->attributes()->general = $_POST["setting_7"];
    } else {
        $xml->rankings_enable_resets->addAttribute("general", $_POST["setting_7"]);
    }
    if ($xml->rankings_enable_resets->attributes()->monthly != NULL) {
        $xml->rankings_enable_resets->attributes()->monthly = $_POST["rankings_enable_resets_monthly"];
    } else {
        $xml->rankings_enable_resets->addAttribute("monthly", $_POST["rankings_enable_resets_monthly"]);
    }
    if ($xml->rankings_enable_resets->attributes()->weekly != NULL) {
        $xml->rankings_enable_resets->attributes()->weekly = $_POST["rankings_enable_resets_weekly"];
    } else {
        $xml->rankings_enable_resets->addAttribute("weekly", $_POST["rankings_enable_resets_weekly"]);
    }
    if ($xml->rankings_enable_resets->attributes()->daily != NULL) {
        $xml->rankings_enable_resets->attributes()->daily = $_POST["rankings_enable_resets_daily"];
    } else {
        $xml->rankings_enable_resets->addAttribute("daily", $_POST["rankings_enable_resets_daily"]);
    }
    if ($xml->rankings_enable_fast_resets->attributes()->general != NULL) {
        $xml->rankings_enable_fast_resets->attributes()->general = $_POST["rankings_enable_fast_resets_general"];
    } else {
        $xml->rankings_enable_fast_resets->addAttribute("general", $_POST["rankings_enable_fast_resets_general"]);
    }
    if ($xml->rankings_enable_gr->attributes()->general != NULL) {
        $xml->rankings_enable_gr->attributes()->general = $_POST["setting_9"];
    } else {
        $xml->rankings_enable_gr->addAttribute("general", $_POST["setting_9"]);
    }
    if ($xml->rankings_enable_gr->attributes()->monthly != NULL) {
        $xml->rankings_enable_gr->attributes()->monthly = $_POST["rankings_enable_gr_monthly"];
    } else {
        $xml->rankings_enable_gr->addAttribute("monthly", $_POST["rankings_enable_gr_monthly"]);
    }
    if ($xml->rankings_enable_gr->attributes()->weekly != NULL) {
        $xml->rankings_enable_gr->attributes()->weekly = $_POST["rankings_enable_gr_weekly"];
    } else {
        $xml->rankings_enable_gr->addAttribute("weekly", $_POST["rankings_enable_gr_weekly"]);
    }
    if ($xml->rankings_enable_gr->attributes()->daily != NULL) {
        $xml->rankings_enable_gr->attributes()->daily = $_POST["rankings_enable_gr_daily"];
    } else {
        $xml->rankings_enable_gr->addAttribute("daily", $_POST["rankings_enable_gr_daily"]);
    }
    if ($xml->rankings_enable_fast_gresets->attributes()->general != NULL) {
        $xml->rankings_enable_fast_gresets->attributes()->general = $_POST["rankings_enable_fast_gresets_general"];
    } else {
        $xml->rankings_enable_fast_gresets->addAttribute("general", $_POST["rankings_enable_fast_gresets_general"]);
    }
    if ($xml->rankings_enable_pk->attributes()->general != NULL) {
        $xml->rankings_enable_pk->attributes()->general = $_POST["setting_8"];
    } else {
        $xml->rankings_enable_pk->addAttribute("general", $_POST["setting_8"]);
    }
    if ($xml->rankings_enable_pk->attributes()->monthly != NULL) {
        $xml->rankings_enable_pk->attributes()->monthly = $_POST["rankings_enable_pk_monthly"];
    } else {
        $xml->rankings_enable_pk->addAttribute("monthly", $_POST["rankings_enable_pk_monthly"]);
    }
    if ($xml->rankings_enable_pk->attributes()->weekly != NULL) {
        $xml->rankings_enable_pk->attributes()->weekly = $_POST["rankings_enable_pk_weekly"];
    } else {
        $xml->rankings_enable_pk->addAttribute("weekly", $_POST["rankings_enable_pk_weekly"]);
    }
    if ($xml->rankings_enable_pk->attributes()->daily != NULL) {
        $xml->rankings_enable_pk->attributes()->daily = $_POST["rankings_enable_pk_daily"];
    } else {
        $xml->rankings_enable_pk->addAttribute("daily", $_POST["rankings_enable_pk_daily"]);
    }
    if ($xml->rankings_enable_online->attributes()->general != NULL) {
        $xml->rankings_enable_online->attributes()->general = $_POST["setting_10"];
    } else {
        $xml->rankings_enable_online->addAttribute("general", $_POST["setting_10"]);
    }
    if ($xml->rankings_enable_online->attributes()->monthly != NULL) {
        $xml->rankings_enable_online->attributes()->monthly = $_POST["rankings_enable_online_monthly"];
    } else {
        $xml->rankings_enable_online->addAttribute("monthly", $_POST["rankings_enable_online_monthly"]);
    }
    if ($xml->rankings_enable_online->attributes()->weekly != NULL) {
        $xml->rankings_enable_online->attributes()->weekly = $_POST["rankings_enable_online_weekly"];
    } else {
        $xml->rankings_enable_online->addAttribute("weekly", $_POST["rankings_enable_online_weekly"]);
    }
    if ($xml->rankings_enable_online->attributes()->daily != NULL) {
        $xml->rankings_enable_online->attributes()->daily = $_POST["rankings_enable_online_daily"];
    } else {
        $xml->rankings_enable_online->addAttribute("daily", $_POST["rankings_enable_online_daily"]);
    }
    if ($xml->rankings_enable_guilds->attributes()->general != NULL) {
        $xml->rankings_enable_guilds->attributes()->general = $_POST["setting_11"];
    } else {
        $xml->rankings_enable_guilds->addAttribute("general", $_POST["setting_11"]);
    }
    if ($xml->rankings_enable_guilds->attributes()->monthly != NULL) {
        $xml->rankings_enable_guilds->attributes()->monthly = $_POST["rankings_enable_guilds_monthly"];
    } else {
        $xml->rankings_enable_guilds->addAttribute("monthly", $_POST["rankings_enable_guilds_monthly"]);
    }
    if ($xml->rankings_enable_guilds->attributes()->weekly != NULL) {
        $xml->rankings_enable_guilds->attributes()->weekly = $_POST["rankings_enable_guilds_weekly"];
    } else {
        $xml->rankings_enable_guilds->addAttribute("weekly", $_POST["rankings_enable_guilds_weekly"]);
    }
    if ($xml->rankings_enable_guilds->attributes()->daily != NULL) {
        $xml->rankings_enable_guilds->attributes()->daily = $_POST["rankings_enable_guilds_daily"];
    } else {
        $xml->rankings_enable_guilds->addAttribute("daily", $_POST["rankings_enable_guilds_daily"]);
    }
    if ($xml->rankings_enable_gens->attributes()->general != NULL) {
        $xml->rankings_enable_gens->attributes()->general = $_POST["setting_14"];
    } else {
        $xml->rankings_enable_gens->addAttribute("general", $_POST["setting_14"]);
    }
    if ($xml->rankings_enable_gens->attributes()->monthly != NULL) {
        $xml->rankings_enable_gens->attributes()->monthly = $_POST["rankings_enable_gens_monthly"];
    } else {
        $xml->rankings_enable_gens->addAttribute("monthly", $_POST["rankings_enable_gens_monthly"]);
    }
    if ($xml->rankings_enable_gens->attributes()->weekly != NULL) {
        $xml->rankings_enable_gens->attributes()->weekly = $_POST["rankings_enable_gens_weekly"];
    } else {
        $xml->rankings_enable_gens->addAttribute("weekly", $_POST["rankings_enable_gens_weekly"]);
    }
    if ($xml->rankings_enable_gens->attributes()->daily != NULL) {
        $xml->rankings_enable_gens->attributes()->daily = $_POST["rankings_enable_gens_daily"];
    } else {
        $xml->rankings_enable_gens->addAttribute("daily", $_POST["rankings_enable_gens_daily"]);
    }
    if ($xml->rankings_enable_votes->attributes()->general != NULL) {
        $xml->rankings_enable_votes->attributes()->general = $_POST["setting_15"];
    } else {
        $xml->rankings_enable_votes->addAttribute("general", $_POST["setting_15"]);
    }
    if ($xml->rankings_enable_votes->attributes()->monthly != NULL) {
        $xml->rankings_enable_votes->attributes()->monthly = $_POST["rankings_enable_votes_monthly"];
    } else {
        $xml->rankings_enable_votes->addAttribute("monthly", $_POST["rankings_enable_votes_monthly"]);
    }
    $_POST["rankings_enable_votes_weekly"] = 0;
    $_POST["rankings_enable_votes_daily"] = 0;
    if ($xml->rankings_enable_votes->attributes()->weekly != NULL) {
        $xml->rankings_enable_votes->attributes()->weekly = $_POST["rankings_enable_votes_weekly"];
    } else {
        $xml->rankings_enable_votes->addAttribute("weekly", $_POST["rankings_enable_votes_weekly"]);
    }
    if ($xml->rankings_enable_votes->attributes()->daily != NULL) {
        $xml->rankings_enable_votes->attributes()->daily = $_POST["rankings_enable_votes_daily"];
    } else {
        $xml->rankings_enable_votes->addAttribute("daily", $_POST["rankings_enable_votes_daily"]);
    }
    $xml->rankings_votes_type = $_POST["setting_30"];
    if ($xml->rankings_enable_honor->attributes()->general != NULL) {
        $xml->rankings_enable_honor->attributes()->general = $_POST["setting_59"];
    } else {
        $xml->rankings_enable_honor->addAttribute("general", $_POST["setting_59"]);
    }
    if ($xml->rankings_enable_afk->attributes()->general != NULL) {
        $xml->rankings_enable_afk->attributes()->general = $_POST["setting_65"];
    } else {
        $xml->rankings_enable_afk->addAttribute("general", $_POST["setting_65"]);
    }
    if ($xml->rankings_enable_afk->attributes()->monthly != NULL) {
        $xml->rankings_enable_afk->attributes()->monthly = $_POST["rankings_enable_afk_monthly"];
    } else {
        $xml->rankings_enable_afk->addAttribute("monthly", $_POST["rankings_enable_afk_monthly"]);
    }
    if ($xml->rankings_enable_afk->attributes()->weekly != NULL) {
        $xml->rankings_enable_afk->attributes()->weekly = $_POST["rankings_enable_afk_weekly"];
    } else {
        $xml->rankings_enable_afk->addAttribute("weekly", $_POST["rankings_enable_afk_weekly"]);
    }
    if ($xml->rankings_enable_afk->attributes()->daily != NULL) {
        $xml->rankings_enable_afk->attributes()->daily = $_POST["rankings_enable_afk_daily"];
    } else {
        $xml->rankings_enable_afk->addAttribute("daily", $_POST["rankings_enable_afk_daily"]);
    }
    $xml->rankings_afk_type = $_POST["setting_71"];
    $xml->rankings_afk_order1 = $_POST["setting_66"];
    $xml->rankings_afk_order2 = $_POST["setting_67"];
    $xml->rankings_afk_order3 = $_POST["setting_68"];
    $xml->rankings_afk_order4 = $_POST["setting_69"];
    $xml->rankings_afk_order5 = $_POST["setting_70"];
    if ($xml->rankings_enable_duels->attributes()->general != NULL) {
        $xml->rankings_enable_duels->attributes()->general = $_POST["setting_17"];
    } else {
        $xml->rankings_enable_duels->addAttribute("general", $_POST["setting_17"]);
    }
    if ($xml->rankings_enable_duels->attributes()->monthly != NULL) {
        $xml->rankings_enable_duels->attributes()->monthly = $_POST["rankings_enable_duels_monthly"];
    } else {
        $xml->rankings_enable_duels->addAttribute("monthly", $_POST["rankings_enable_duels_monthly"]);
    }
    if ($xml->rankings_enable_duels->attributes()->weekly != NULL) {
        $xml->rankings_enable_duels->attributes()->weekly = $_POST["rankings_enable_duels_weekly"];
    } else {
        $xml->rankings_enable_duels->addAttribute("weekly", $_POST["rankings_enable_duels_weekly"]);
    }
    if ($xml->rankings_enable_duels->attributes()->daily != NULL) {
        $xml->rankings_enable_duels->attributes()->daily = $_POST["rankings_enable_duels_daily"];
    } else {
        $xml->rankings_enable_duels->addAttribute("daily", $_POST["rankings_enable_duels_daily"]);
    }
    if ($xml->rankings_enable_devilsquare->attributes()->general != NULL) {
        $xml->rankings_enable_devilsquare->attributes()->general = $_POST["setting_18"];
    } else {
        $xml->rankings_enable_devilsquare->addAttribute("general", $_POST["setting_18"]);
    }
    if ($xml->rankings_enable_devilsquare->attributes()->monthly != NULL) {
        $xml->rankings_enable_devilsquare->attributes()->monthly = $_POST["rankings_enable_devilsquare_monthly"];
    } else {
        $xml->rankings_enable_devilsquare->addAttribute("monthly", $_POST["rankings_enable_devilsquare_monthly"]);
    }
    if ($xml->rankings_enable_devilsquare->attributes()->weekly != NULL) {
        $xml->rankings_enable_devilsquare->attributes()->weekly = $_POST["rankings_enable_devilsquare_weekly"];
    } else {
        $xml->rankings_enable_devilsquare->addAttribute("weekly", $_POST["rankings_enable_devilsquare_weekly"]);
    }
    if ($xml->rankings_enable_devilsquare->attributes()->daily != NULL) {
        $xml->rankings_enable_devilsquare->attributes()->daily = $_POST["rankings_enable_devilsquare_daily"];
    } else {
        $xml->rankings_enable_devilsquare->addAttribute("daily", $_POST["rankings_enable_devilsquare_daily"]);
    }
    if ($xml->rankings_enable_bloodcastle->attributes()->general != NULL) {
        $xml->rankings_enable_bloodcastle->attributes()->general = $_POST["setting_19"];
    } else {
        $xml->rankings_enable_bloodcastle->addAttribute("general", $_POST["setting_19"]);
    }
    if ($xml->rankings_enable_bloodcastle->attributes()->monthly != NULL) {
        $xml->rankings_enable_bloodcastle->attributes()->monthly = $_POST["rankings_enable_bloodcastle_monthly"];
    } else {
        $xml->rankings_enable_bloodcastle->addAttribute("monthly", $_POST["rankings_enable_bloodcastle_monthly"]);
    }
    if ($xml->rankings_enable_bloodcastle->attributes()->weekly != NULL) {
        $xml->rankings_enable_bloodcastle->attributes()->weekly = $_POST["rankings_enable_bloodcastle_weekly"];
    } else {
        $xml->rankings_enable_bloodcastle->addAttribute("weekly", $_POST["rankings_enable_bloodcastle_weekly"]);
    }
    if ($xml->rankings_enable_bloodcastle->attributes()->daily != NULL) {
        $xml->rankings_enable_bloodcastle->attributes()->daily = $_POST["rankings_enable_bloodcastle_daily"];
    } else {
        $xml->rankings_enable_bloodcastle->addAttribute("daily", $_POST["rankings_enable_bloodcastle_daily"]);
    }
    if ($xml->rankings_enable_chaoscastle->attributes()->general != NULL) {
        $xml->rankings_enable_chaoscastle->attributes()->general = $_POST["setting_20"];
    } else {
        $xml->rankings_enable_chaoscastle->addAttribute("general", $_POST["setting_20"]);
    }
    if ($xml->rankings_enable_chaoscastle->attributes()->monthly != NULL) {
        $xml->rankings_enable_chaoscastle->attributes()->monthly = $_POST["rankings_enable_chaoscastle_monthly"];
    } else {
        $xml->rankings_enable_chaoscastle->addAttribute("monthly", $_POST["rankings_enable_chaoscastle_monthly"]);
    }
    if ($xml->rankings_enable_chaoscastle->attributes()->weekly != NULL) {
        $xml->rankings_enable_chaoscastle->attributes()->weekly = $_POST["rankings_enable_chaoscastle_weekly"];
    } else {
        $xml->rankings_enable_chaoscastle->addAttribute("weekly", $_POST["rankings_enable_chaoscastle_weekly"]);
    }
    if ($xml->rankings_enable_chaoscastle->attributes()->daily != NULL) {
        $xml->rankings_enable_chaoscastle->attributes()->daily = $_POST["rankings_enable_chaoscastle_daily"];
    } else {
        $xml->rankings_enable_chaoscastle->addAttribute("daily", $_POST["rankings_enable_chaoscastle_daily"]);
    }
    if ($xml->rankings_enable_illusiontemple->attributes()->general != NULL) {
        $xml->rankings_enable_illusiontemple->attributes()->general = $_POST["setting_21"];
    } else {
        $xml->rankings_enable_illusiontemple->addAttribute("general", $_POST["setting_21"]);
    }
    if ($xml->rankings_enable_illusiontemple->attributes()->monthly != NULL) {
        $xml->rankings_enable_illusiontemple->attributes()->monthly = $_POST["rankings_enable_illusiontemple_monthly"];
    } else {
        $xml->rankings_enable_illusiontemple->addAttribute("monthly", $_POST["rankings_enable_illusiontemple_monthly"]);
    }
    if ($xml->rankings_enable_illusiontemple->attributes()->weekly != NULL) {
        $xml->rankings_enable_illusiontemple->attributes()->weekly = $_POST["rankings_enable_illusiontemple_weekly"];
    } else {
        $xml->rankings_enable_illusiontemple->addAttribute("weekly", $_POST["rankings_enable_illusiontemple_weekly"]);
    }
    if ($xml->rankings_enable_illusiontemple->attributes()->daily != NULL) {
        $xml->rankings_enable_illusiontemple->attributes()->daily = $_POST["rankings_enable_illusiontemple_daily"];
    } else {
        $xml->rankings_enable_illusiontemple->addAttribute("daily", $_POST["rankings_enable_illusiontemple_daily"]);
    }
    if ($xml->rankings_enable_cshistory->attributes()->general != NULL) {
        $xml->rankings_enable_cshistory->attributes()->general = $_POST["setting_22"];
    } else {
        $xml->rankings_enable_cshistory->addAttribute("general", $_POST["setting_22"]);
    }
    if (!$General->ftanHCIfo_canUse_j8GsnawwvJ_Module("arkawar")) {
        $_POST["arkawar_history"] = 0;
    }
    if ($xml->rankings_enable_arkawar_history->attributes()->general != NULL) {
        $xml->rankings_enable_arkawar_history->attributes()->general = $_POST["arkawar_history"];
    } else {
        $xml->rankings_enable_arkawar_history->addAttribute("general", $_POST["arkawar_history"]);
    }
    if (!$General->ftanHCIfo_canUse_j8GsnawwvJ_Module("icewindvalley")) {
        $_POST["icewindvalley_history"] = 0;
    }
    if ($xml->rankings_enable_icewindvalley_history->attributes()->general != NULL) {
        $xml->rankings_enable_icewindvalley_history->attributes()->general = $_POST["icewindvalley_history"];
    } else {
        $xml->rankings_enable_icewindvalley_history->addAttribute("general", $_POST["icewindvalley_history"]);
    }
    if ($xml->rankings_enable_online_players->attributes()->general != NULL) {
        $xml->rankings_enable_online_players->attributes()->general = $_POST["setting_23"];
    } else {
        $xml->rankings_enable_online_players->addAttribute("general", $_POST["setting_23"]);
    }
    $xml->rankings_guild_type = $_POST["setting_24"];
    if ($xml->rankings_enable_achievements->attributes()->general != NULL) {
        $xml->rankings_enable_achievements->attributes()->general = $_POST["setting_25"];
    } else {
        $xml->rankings_enable_achievements->addAttribute("general", $_POST["setting_25"]);
    }
    $xml->rankings_gens_stat = $_POST["setting_26"];
    if ($xml->rankings_enable_married->attributes()->general != NULL) {
        $xml->rankings_enable_married->attributes()->general = $_POST["setting_27"];
    } else {
        $xml->rankings_enable_married->addAttribute("general", $_POST["setting_27"]);
    }
    if ($xml->rankings_enable_score->attributes()->general != NULL) {
        $xml->rankings_enable_score->attributes()->general = $_POST["setting_40"];
    } else {
        $xml->rankings_enable_score->addAttribute("general", $_POST["setting_40"]);
    }
    $xml->score_rankings_lvl = $_POST["setting_41"];
    $xml->score_rankings_mlvl = $_POST["setting_42"];
    $xml->score_rankings_reset = $_POST["setting_43"];
    $xml->score_rankings_greset = $_POST["setting_44"];
    $xml->score_rankings_stats = $_POST["setting_45"];
    $xml->score_rankings_achiev = $_POST["setting_46"];
    $xml->score_rankings_duel_win = $_POST["setting_47"];
    $xml->score_rankings_duel_lose = $_POST["setting_48"];
    $xml->score_rankings_gens_rank = $_POST["setting_49"];
    $xml->score_rankings_gens_points = $_POST["setting_50"];
    $xml->score_rankings_gens_class = $_POST["setting_51"];
    $xml->score_rankings_ds = $_POST["setting_52"];
    $xml->score_rankings_bc = $_POST["setting_53"];
    $xml->score_rankings_cc = $_POST["setting_54"];
    $xml->score_rankings_it = $_POST["setting_55"];
    $xml->rankings_killers_type = $_POST["setting_56"];
    $xml->honor_level = $_POST["setting_60"];
    $xml->honor_mlevel = $_POST["setting_61"];
    $xml->honor_reset = $_POST["setting_62"];
    $xml->honor_greset = $_POST["setting_63"];
    $xml->include_honor_on_char_rankings = $_POST["setting_64"];
    $xml->rewards_characters = NULL;
    if ($xml->rewards_characters->attributes()->daily != NULL) {
        $xml->rewards_characters->attributes()->daily = $_POST["rewards_characters_daily"];
    } else {
        $xml->rewards_characters->addAttribute("daily", $_POST["rewards_characters_daily"]);
    }
    if ($xml->rewards_characters->attributes()->weekly != NULL) {
        $xml->rewards_characters->attributes()->weekly = $_POST["rewards_characters_weekly"];
    } else {
        $xml->rewards_characters->addAttribute("weekly", $_POST["rewards_characters_weekly"]);
    }
    if ($xml->rewards_characters->attributes()->monthly != NULL) {
        $xml->rewards_characters->attributes()->monthly = $_POST["rewards_characters_monthly"];
    } else {
        $xml->rewards_characters->addAttribute("monthly", $_POST["rewards_characters_monthly"]);
    }
    $xml->rewards_guilds = NULL;
    if ($xml->rewards_guilds->attributes()->daily != NULL) {
        $xml->rewards_guilds->attributes()->daily = $_POST["rewards_guilds_daily"];
    } else {
        $xml->rewards_guilds->addAttribute("daily", $_POST["rewards_guilds_daily"]);
    }
    if ($xml->rewards_guilds->attributes()->weekly != NULL) {
        $xml->rewards_guilds->attributes()->weekly = $_POST["rewards_guilds_weekly"];
    } else {
        $xml->rewards_guilds->addAttribute("weekly", $_POST["rewards_guilds_weekly"]);
    }
    if ($xml->rewards_guilds->attributes()->monthly != NULL) {
        $xml->rewards_guilds->attributes()->monthly = $_POST["rewards_guilds_monthly"];
    } else {
        $xml->rewards_guilds->addAttribute("monthly", $_POST["rewards_guilds_monthly"]);
    }
    $xml->rewards_killers = NULL;
    if ($xml->rewards_killers->attributes()->daily != NULL) {
        $xml->rewards_killers->attributes()->daily = $_POST["rewards_killers_daily"];
    } else {
        $xml->rewards_killers->addAttribute("daily", $_POST["rewards_killers_daily"]);
    }
    if ($xml->rewards_killers->attributes()->weekly != NULL) {
        $xml->rewards_killers->attributes()->weekly = $_POST["rewards_killers_weekly"];
    } else {
        $xml->rewards_killers->addAttribute("weekly", $_POST["rewards_killers_weekly"]);
    }
    if ($xml->rewards_killers->attributes()->monthly != NULL) {
        $xml->rewards_killers->attributes()->monthly = $_POST["rewards_killers_monthly"];
    } else {
        $xml->rewards_killers->addAttribute("monthly", $_POST["rewards_killers_monthly"]);
    }
    $xml->rewards_duels = NULL;
    if ($xml->rewards_duels->attributes()->daily != NULL) {
        $xml->rewards_duels->attributes()->daily = $_POST["rewards_duels_daily"];
    } else {
        $xml->rewards_duels->addAttribute("daily", $_POST["rewards_duels_daily"]);
    }
    if ($xml->rewards_duels->attributes()->weekly != NULL) {
        $xml->rewards_duels->attributes()->weekly = $_POST["rewards_duels_weekly"];
    } else {
        $xml->rewards_duels->addAttribute("weekly", $_POST["rewards_duels_weekly"]);
    }
    if ($xml->rewards_duels->attributes()->monthly != NULL) {
        $xml->rewards_duels->attributes()->monthly = $_POST["rewards_duels_monthly"];
    } else {
        $xml->rewards_duels->addAttribute("monthly", $_POST["rewards_duels_monthly"]);
    }
    $xml->rewards_votes = NULL;
    if ($xml->rewards_votes->attributes()->monthly != NULL) {
        $xml->rewards_votes->attributes()->monthly = $_POST["rewards_votes_monthly"];
    } else {
        $xml->rewards_votes->addAttribute("monthly", $_POST["rewards_votes_monthly"]);
    }
    $xml->rewards_bc = NULL;
    if ($xml->rewards_bc->attributes()->daily != NULL) {
        $xml->rewards_bc->attributes()->daily = $_POST["rewards_bc_daily"];
    } else {
        $xml->rewards_bc->addAttribute("daily", $_POST["rewards_bc_daily"]);
    }
    if ($xml->rewards_bc->attributes()->weekly != NULL) {
        $xml->rewards_bc->attributes()->weekly = $_POST["rewards_bc_weekly"];
    } else {
        $xml->rewards_bc->addAttribute("weekly", $_POST["rewards_bc_weekly"]);
    }
    if ($xml->rewards_bc->attributes()->monthly != NULL) {
        $xml->rewards_bc->attributes()->monthly = $_POST["rewards_bc_monthly"];
    } else {
        $xml->rewards_bc->addAttribute("monthly", $_POST["rewards_bc_monthly"]);
    }
    $xml->rewards_ds = NULL;
    if ($xml->rewards_ds->attributes()->daily != NULL) {
        $xml->rewards_ds->attributes()->daily = $_POST["rewards_ds_daily"];
    } else {
        $xml->rewards_ds->addAttribute("daily", $_POST["rewards_ds_daily"]);
    }
    if ($xml->rewards_ds->attributes()->weekly != NULL) {
        $xml->rewards_ds->attributes()->weekly = $_POST["rewards_ds_weekly"];
    } else {
        $xml->rewards_ds->addAttribute("weekly", $_POST["rewards_ds_weekly"]);
    }
    if ($xml->rewards_ds->attributes()->monthly != NULL) {
        $xml->rewards_ds->attributes()->monthly = $_POST["rewards_ds_monthly"];
    } else {
        $xml->rewards_ds->addAttribute("monthly", $_POST["rewards_ds_monthly"]);
    }
    $xml->rewards_cc = NULL;
    if ($xml->rewards_cc->attributes()->daily != NULL) {
        $xml->rewards_cc->attributes()->daily = $_POST["rewards_cc_daily"];
    } else {
        $xml->rewards_cc->addAttribute("daily", $_POST["rewards_cc_daily"]);
    }
    if ($xml->rewards_cc->attributes()->weekly != NULL) {
        $xml->rewards_cc->attributes()->weekly = $_POST["rewards_cc_weekly"];
    } else {
        $xml->rewards_cc->addAttribute("weekly", $_POST["rewards_cc_weekly"]);
    }
    if ($xml->rewards_cc->attributes()->monthly != NULL) {
        $xml->rewards_cc->attributes()->monthly = $_POST["rewards_cc_monthly"];
    } else {
        $xml->rewards_cc->addAttribute("monthly", $_POST["rewards_cc_monthly"]);
    }
    $xml->rewards_it = NULL;
    if ($xml->rewards_it->attributes()->daily != NULL) {
        $xml->rewards_it->attributes()->daily = $_POST["rewards_it_daily"];
    } else {
        $xml->rewards_it->addAttribute("daily", $_POST["rewards_it_daily"]);
    }
    if ($xml->rewards_it->attributes()->weekly != NULL) {
        $xml->rewards_it->attributes()->weekly = $_POST["rewards_it_weekly"];
    } else {
        $xml->rewards_it->addAttribute("weekly", $_POST["rewards_it_weekly"]);
    }
    if ($xml->rewards_it->attributes()->monthly != NULL) {
        $xml->rewards_it->attributes()->monthly = $_POST["rewards_it_monthly"];
    } else {
        $xml->rewards_it->addAttribute("monthly", $_POST["rewards_it_monthly"]);
    }
    $save = $xml->asXML($xmlPath);
    if ($save) {
        message("success", "Settings successfully saved.");
    } else {
        message("error", "There has been an error while saving changes.");
    }
}

?>