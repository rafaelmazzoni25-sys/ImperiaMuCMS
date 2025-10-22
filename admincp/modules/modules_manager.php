<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$imperiamucmsModules = ["_global" => [["News", "news"], ["Changelog", "changelog"], ["Login", "login"], ["Register", "register"], ["Downloads", "downloads"], ["Rankings", "rankings"], ["Castle Siege", "castlesiege"], ["Arka War", "arkawar"], ["Ice Wind Valley", "icewindvalley"], ["Email System", "email"], ["Profiles", "profiles"], ["IP Board 4 API", "ipboardapi"], ["Events Timer", "eventstimer"], ["Boss Timer", "bosstimer"], ["Cash Shop Gifts", "cashshopgifts"], ["UserCP", "usercp"]], "_donation" => [["Donation", "donation"], ["PayPal", "paypal"], ["Paymentwall", "paymentwall"], ["PayGol", "paygol"], ["Pay.nl", "paynl"], ["SuperRewards", "superrewards"], ["Western Union", "westernunion"], ["PagSeguro", "pagseguro"], ["Homepay.pl", "homepaypl"], ["PayU.pl", "payu"], ["MercadoPago", "mercadopago"], ["Interkassa", "interkassa"], ["NganLuong", "nganluong"], ["Nạp thẻ Cào", "manual_donation"], ["TMPay", "tmpay"]], "_usercp" => [["Reset", "reset"], ["Grand Reset", "greset"], ["Add Stats", "addstats"], ["Reset Stats", "resetstats"], ["Dual Stats", "dualstats"], ["Dual Skill Tree", "dualskilltree"], ["Clear PK", "clearpk"], ["Clear Inventory", "clearinv"], ["Clear Event Inventory", "cleareventinv"], ["Clear Skills", "clearskills"], ["Clear Skill-Tree", "clearskilltree"], ["Clear 4th Skill-Tree", "clear4thskilltree"], ["Clear Trees", "cleartrees"], ["Unstuck Character", "unstuck"], ["Change Name", "changename"], ["Change Class", "changeclass"], ["Account Balance", "balance"], ["Market", "market"], ["Exchange", "exchange"], ["Web Bank", "webbank"], ["Guild Web Bank", "webbankguild"], ["My Vault", "myvault"], ["Items Inventory", "itemsinventory"], ["VIP", "vip"], ["Vote", "vote"], ["Recruit a Friend", "recruit"], ["Transfer Coins", "transfercoins"], ["Transfer Character", "transfercharacter"], ["Change Password", "mypassword"], ["Change Email", "myemail"], ["Account Activities", "logs"], ["Claim Reward", "claimreward"], ["Starting Kit", "startingkit"], ["Wheel of Fortune", "wheeloffortune"], ["Architect", "architect"], ["Activity Rewards", "activityrewards"], ["My Characters", "mycharacters"]]];
if (config("server_files_season", true) < 131) {
    unset($imperiamucmsModules["_usercp"][11]);
}
$General = new xGeneral();
if (!$General->ftanHCIfo_canUse_j8GsnawwvJ_Module("cleartrees")) {
    unset($imperiamucmsModules["_usercp"][12]);
}
if (!$General->ftanHCIfo_canUse_j8GsnawwvJ_Module("manual_donation")) {
    unset($imperiamucmsModules["_donation"][13]);
}
if (!$General->ftanHCIfo_canUse_j8GsnawwvJ_Module("tmpay")) {
    unset($imperiamucmsModules["_donation"][14]);
}
if (!$General->ftanHCIfo_canUse_j8GsnawwvJ_Module("arkawar")) {
    unset($imperiamucmsModules["_global"][7]);
}
if (!$General->ftanHCIfo_canUse_j8GsnawwvJ_Module("icewindvalley")) {
    unset($imperiamucmsModules["_global"][8]);
}
if (!$General->ftanHCIfo_canUse_j8GsnawwvJ_Module("cashshopgifts")) {
    unset($imperiamucmsModules["_global"][14]);
}
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("reset-types")) {
    $imperiamucmsModules["_usercp"][0] = ["Reset", "reset-types"];
}
echo "<h1 class=\"page-header\">Modules Manager</h1><div class=\"row\"><div class=\"col-md-6\"><h4>Global:</h4><div class=\"modulesManager\"><ul>";
foreach ($imperiamucmsModules["_global"] as $moduleList) {
    echo "<li><a href=\"" . admincp_base("modules_manager&config=" . $moduleList[1]) . "\">" . $moduleList[0] . "</a></li>";
}
echo "</ul></div><h4>Donation:</h4><div class=\"modulesManager\"><ul>";
foreach ($imperiamucmsModules["_donation"] as $moduleList) {
    echo "<li><a href=\"" . admincp_base("modules_manager&config=" . $moduleList[1]) . "\">" . $moduleList[0] . "</a></li>";
}
echo "</ul></div></div><div class=\"col-md-6\"><h4>User CP:</h4><div class=\"modulesManager\"><ul>";
foreach ($imperiamucmsModules["_usercp"] as $moduleList) {
    echo "<li><a href=\"" . admincp_base("modules_manager&config=" . $moduleList[1]) . "\">" . $moduleList[0] . "</a></li>";
}
echo "</ul></div></div></div><hr>";
if (check_value($_GET["config"])) {
    $filePath = __PATH_ADMINCP_MODULES__ . "mconfig/" . $_GET["config"] . ".php";
    if (file_exists($filePath)) {
        include $filePath;
    } else {
        message("error", "Invalid module.");
    }
}

?>