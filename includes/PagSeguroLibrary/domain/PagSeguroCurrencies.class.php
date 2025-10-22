<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroCurrencies
{
    private static $currencies = ["REAL" => "BRL"];
    public static function checkCurrencyAvailabilityByIsoCode($currency_iso_code)
    {
        $available = false;
        if (array_search(strtoupper($currency_iso_code), self::$currencies)) {
            $available = true;
        }
        return $available;
    }
    public static function checkCurrencyAvailabilityByName($name)
    {
        $available = false;
        if (array_key_exists(strtoupper($name), self::$currencies)) {
            $available = true;
        }
        return $available;
    }
    public static function getIsoCodeByName($name)
    {
        $name = strtoupper($name);
        return isset(self::$currencies[$name]) ? self::$currencies[$name] : self::$currencies["REAL"];
    }
    public static function getCurrencyNameByIsoCode($iso_code)
    {
        return array_search(strtoupper($iso_code), $this::getCurrenciesList());
    }
    public static function getCurrenciesList()
    {
        return self::$currencies;
    }
}

?>