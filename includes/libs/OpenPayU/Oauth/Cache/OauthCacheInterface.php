<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

final class OauthCacheInterface
{
    public abstract function get($key);
    public abstract function set($key, $value);
    public abstract function invalidate($key);
}

?>