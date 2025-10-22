<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$configError = [];
$writablePaths = ["cache/", "cache/news/", "cache/changelogs/", "cache/profiles/guilds/", "cache/profiles/players/", "cache/castle_siege.cache", "cache/cron.cache", "cache/cshistory.cache", "cache/downloads.cache", "cache/news.cache", "cache/plugins.cache", "cache/rankings_achievements.cache", "cache/rankings_bloodcastle.cache", "cache/rankings_cshistory.cache", "cache/rankings_devilsquare.cache", "cache/rankings_duels.cache", "cache/rankings_gens.cache", "cache/rankings_gens_duprian.cache", "cache/rankings_gens_vanert.cache", "cache/rankings_gr.cache", "cache/rankings_guilds.cache", "cache/rankings_chaoscastle.cache", "cache/rankings_characters.cache", "cache/rankings_characters_wizard.cache", "cache/rankings_characters_knight.cache", "cache/rankings_characters_elf.cache", "cache/rankings_characters_summoner.cache", "cache/rankings_characters_gladiator.cache", "cache/rankings_characters_lord.cache", "cache/rankings_characters_fighter.cache", "cache/rankings_illusiontemple.cache", "cache/rankings_level.cache", "cache/rankings_master.cache", "cache/rankings_online.cache", "cache/rankings_pk.cache", "cache/rankings_pvplaststand.cache", "cache/rankings_resets.cache", "cache/rankings_votes.cache", "cache/reward_top_voters.cache", "cache/server_info.cache", "config/email.xml", "config/modules/about.xml", "config/modules/bugtracker.xml", "config/modules/castlesiege.xml", "config/modules/contact.xml", "config/modules/donation.paypal.xml", "config/modules/donation.superrewards.xml", "config/modules/donation.paymentwall.xml", "config/modules/donation.paynl.xml", "config/modules/donation.westernunion.xml", "config/modules/donation.pagseguro.xml", "config/modules/donation.xml", "config/modules/downloads.xml", "config/modules/changelog.xml", "config/modules/login.xml", "config/modules/news.xml", "config/modules/profiles.xml", "config/modules/rankings.xml", "config/modules/register.xml", "config/modules/statistics.xml", "config/modules/ticket.xml", "config/modules/usercp.addstats.xml", "config/modules/usercp.achievements.quests.xml", "config/modules/usercp.achievements.xml", "config/modules/usercp.clearinv.xml", "config/modules/usercp.clearpk.xml", "config/modules/usercp.clearskills.xml", "config/modules/usercp.clearskilltree.xml", "config/modules/usercp.dualstats.xml", "config/modules/usercp.dualskilltree.xml", "config/modules/usercp.exchange.xml", "config/modules/usercp.greset.xml", "config/modules/usercp.items.xml", "config/modules/usercp.logs.xml", "config/modules/usercp.market.xml", "config/modules/usercp.myaccount.xml", "config/modules/usercp.myemail.xml", "config/modules/usercp.mypassword.xml", "config/modules/usercp.promo.xml", "config/modules/usercp.recruit.xml", "config/modules/usercp.reset.xml", "config/modules/usercp.resetstats.xml", "config/modules/usercp.transfercoins.xml", "config/modules/usercp.transfercharacter.xml", "config/modules/usercp.unstuck.xml", "config/modules/usercp.vault.xml", "config/modules/usercp.vip.xml", "config/modules/usercp.vote.xml", "config/modules/usercp.webbank.xml", "config/modules/webshop.xml", "PagSeguroLibrary/log/donationslog/"];
foreach ($writablePaths as $thisPath) {
    if (file_exists(__PATH_INCLUDES__ . $thisPath)) {
        if (!is_writable(__PATH_INCLUDES__ . $thisPath)) {
            $configError[] = "<span style=\"color:#aaaaaa;\">[Permission Error]</span> " . $thisPath . " <span style=\"color:red;\">(file must be writable)</span>";
        }
    } else {
        $configError[] = "<span style=\"color:#aaaaaa;\">[Not Found]</span> " . $thisPath . " <span style=\"color:orange;\">(re-upload file)</span>";
    }
}
if (!check_value($config["encryption_hash"])) {
    $configError[] = "<span style=\"color:#aaaaaa;\">[Configuration]</span> encryption_hash <span style=\"color:green;\">(must be configured)</span>";
} else {
    if (!in_array(strlen($config["encryption_hash"]), [16, 24, 32])) {
        $configError[] = "<span style=\"color:#aaaaaa;\">[Configuration]</span> encryption_hash <span style=\"color:green;\">(must have 16, 24 or 32 characters)</span>";
    }
}
if (!function_exists("curl_version")) {
    $configError[] = "<span style=\"color:#aaaaaa;\">[PHP]</span> <span style=\"color:green;\">curl not loaded (ImperiaMuCMS required cURL)</span>";
}
if (1 <= count($configError)) {
    throw new Exception("<strong>The following errors ocurred:</strong><br /><br />" . implode("<br />", $configError));
}

?>