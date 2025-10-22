<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
if (!check_value($_REQUEST["subpage"])) {
    redirect(1, $_REQUEST["page"] . "/" . mconfig("ticket_show_default") . "/");
}

?>