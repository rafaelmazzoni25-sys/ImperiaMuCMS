<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Paymentwall_Response_Success extends Paymentwall_Response_Abstract implements Paymentwall_Response_Interface
{
    public function process()
    {
        if (!isset($this->response)) {
            return $this->wrapInternalError();
        }
        $response = ["success" => 1];
        return json_encode($response);
    }
}

?>