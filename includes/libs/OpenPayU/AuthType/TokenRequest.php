<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class AuthType_TokenRequest implements AuthType
{
    public function getHeaders()
    {
        return ["Content-Type: application/x-www-form-urlencoded", "Accept: */*"];
    }
}

?>