<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Paymentwall_Signature_Pingback extends Paymentwall_Signature_Abstract
{
    public function process($params = [], $version = 0)
    {
        $baseString = "";
        unset($params["sig"]);
        if ($version == VERSION_TWO || $version == VERSION_THREE) {
            $this::ksortMultiDimensional($params);
        }
        $baseString = $this->prepareParams($params, $baseString);
        $baseString .= $this->getConfig()->getPrivateKey();
        if ($version == VERSION_THREE) {
            return hash("sha256", $baseString);
        }
        return md5($baseString);
    }
    public function prepareParams($params = [], $baseString = "")
    {
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $baseString .= $key . "[" . $k . "]" . "=" . $v;
                }
            } else {
                $baseString .= $key . "=" . $value;
            }
        }
        return $baseString;
    }
}

?>