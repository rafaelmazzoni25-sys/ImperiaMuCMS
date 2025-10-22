<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Online Accounts</h1>\r\n";
$onlinedb = config("SQL_USE_2_DB", true) ? $dB2 : $dB;
$online = $onlinedb->query_fetch("SELECT " . _CLMN_MS_MEMBID_ . "," . _CLMN_MS_GS_ . " FROM " . _TBL_MS_ . " WHERE " . _CLMN_CONNSTAT_ . " = 1");
if (is_array($online)) {
    message("info", count($online), "Total Online:");
    echo "<table class=\"table table-condensed table-hover\">\r\n\t<thead>\r\n\t<tr>\r\n\t<th>Account</th>\r\n\t<th>Character</th>\r\n\t<th>Server</th>\r\n\t<th></th>\r\n\t</tr>\r\n\t</thead>\r\n\t<tbody>";
    foreach ($online as $thisAccount) {
        $char = $dB->query_fetch_single("SELECT GameIDC FROM AccountCharacter WHERE Id = ?", [$thisAccount[_CLMN_MS_MEMBID_]]);
        echo "<tr>";
        echo "<td>" . $thisAccount[_CLMN_MS_MEMBID_] . "</td>";
        echo "<td>" . $common->replaceHtmlSymbols($char["GameIDC"]) . "</td>";
        echo "<td>" . $thisAccount[_CLMN_MS_GS_] . "</td>";
        echo "<td style=\"text-align:right;\"><a href=\"" . admincp_base("accountinfo&id=" . $common->retrieveUserID($thisAccount[_CLMN_MS_MEMBID_])) . "\" class=\"btn btn-xs btn-default\">Account Information</a></td>";
        echo "</tr>";
    }
    echo "\r\n\t</tbody>\r\n\t</table>";
} else {
    message("error", "No online accounts.");
}

?>