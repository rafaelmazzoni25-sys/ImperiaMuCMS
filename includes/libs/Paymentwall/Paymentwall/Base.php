<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Paymentwall_Base extends Paymentwall_Config
{
    public static function setApiType($apiType = 0)
    {
        return $this::getInstance()->setLocalApiType($apiType);
    }
    public static function setAppKey($appKey = "")
    {
        return $this::getInstance()->setPublicKey($appKey);
    }
    public static function setSecretKey($secretKey = "")
    {
        return $this::getInstance()->setPrivateKey($secretKey);
    }
}

?>