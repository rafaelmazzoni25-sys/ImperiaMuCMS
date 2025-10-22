<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

abstract class Paymentwall_Signature_Abstract extends Paymentwall_Instance
{
    const VERSION_ONE = 1;
    const VERSION_TWO = 2;
    const VERSION_THREE = 3;
    const DEFAULT_VERSION = 3;
    public abstract function process($params, $version);
    public abstract function prepareParams($params, $baseString);
    public final function calculate($params = [], $version = 0)
    {
        return $this->process($params, $version);
    }
    protected function ksortMultiDimensional(&$params = [])
    {
        if (is_array($params)) {
            ksort($params);
            if (is_array($p)) {
                ksort($p);
            }
        }
    }
}

?>