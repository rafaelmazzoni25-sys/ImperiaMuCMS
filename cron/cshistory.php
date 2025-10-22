<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
$csData = $dB->query_fetch_single("SELECT TOP 1 * FROM MuCastle_DATA");
$csHistory = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_CS_HISTORY ORDER BY SIEGE_END_DATE DESC");
$guildData = $dB->query_fetch_single("SELECT G_Master FROM Guild WHERE G_Name = ?", [$csData["OWNER_GUILD"]]);
if ($csData["OWNER_GUILD"] != NULL) {
    if ($csHistory["SIEGE_END_DATE"] == NULL) {
        $check = $dB->query("INSERT INTO IMPERIAMUCMS_CS_HISTORY (MAP_SVR_GROUP,SIEGE_START_DATE,SIEGE_END_DATE,OWNER_GUILD,GUILD_MASTER,MONEY,TAX_RATE_CHAOS,TAX_RATE_STORE,TAX_HUNT_ZONE)\r\n                VALUES (?,?,?,?,?,?,?,?,?)", [$csData["MAP_SVR_GROUP"], $csData["SIEGE_START_DATE"], $csData["SIEGE_END_DATE"], $csData["OWNER_GUILD"], $guildData["G_Master"], $csData["MONEY"], $csData["TAX_RATE_CHAOS"], $csData["TAX_RATE_STORE"], $csData["TAX_HUNT_ZONE"]]);
    } else {
        if ($csHistory["SIEGE_END_DATE"] != $csData["SIEGE_END_DATE"]) {
            $check = $dB->query("INSERT INTO IMPERIAMUCMS_CS_HISTORY (MAP_SVR_GROUP,SIEGE_START_DATE,SIEGE_END_DATE,OWNER_GUILD,GUILD_MASTER,MONEY,TAX_RATE_CHAOS,TAX_RATE_STORE,TAX_HUNT_ZONE)\r\n                VALUES (?,?,?,?,?,?,?,?,?)", [$csData["MAP_SVR_GROUP"], $csData["SIEGE_START_DATE"], $csData["SIEGE_END_DATE"], $csData["OWNER_GUILD"], $guildData["G_Master"], $csData["MONEY"], $csData["TAX_RATE_CHAOS"], $csData["TAX_RATE_STORE"], $csData["TAX_HUNT_ZONE"]]);
        }
    }
}
updateCronLastRun($file_name);

?>