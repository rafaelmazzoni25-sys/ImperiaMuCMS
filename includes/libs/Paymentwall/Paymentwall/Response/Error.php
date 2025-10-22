<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Paymentwall_Response_Error extends Paymentwall_Response_Abstract implements Paymentwall_Response_Interface
{
    public function process()
    {
        if (!isset($this->response)) {
            return $this->wrapInternalError();
        }
        $response = ["success" => 0, "error" => $this->getErrorMessageAndCode($this->response)];
        return json_encode($response);
    }
    public function getErrorMessageAndCode($response)
    {
        return ["message" => $response["error"], "code" => $response["code"]];
    }
}

?>