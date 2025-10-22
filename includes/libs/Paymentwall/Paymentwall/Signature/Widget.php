<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Paymentwall_Signature_Widget extends Paymentwall_Signature_Abstract
{
    public function process($params = [], $version = 0)
    {
        $baseString = "";
        if ($version == VERSION_ONE) {
            $baseString .= isset($params["uid"]) ? $params["uid"] : "";
            $baseString .= $this->getConfig()->getPrivateKey();
            return md5($baseString);
        }
        $this::ksortMultiDimensional($params);
        $baseString = $this->prepareParams($params, $baseString);
        $baseString .= $this->getConfig()->getPrivateKey();
        if ($version == VERSION_TWO) {
            return md5($baseString);
        }
        return hash("sha256", $baseString);
    }
    public function prepareParams($params = [], $baseString = "")
    {
        foreach ($params as $key => $value) {
            if (isset($value)) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $baseString .= $key . "[" . $k . "]" . "=" . ($v === false ? "0" : $v);
                    }
                } else {
                    $baseString .= $key . "=" . ($value === false ? "0" : $value);
                }
            }
        }
        return $baseString;
    }
}

?>