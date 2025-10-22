<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

abstract class Paymentwall_Response_Abstract
{
    protected $response = NULL;
    public function __construct($response = [])
    {
        $this->response = $response;
    }
    protected function wrapInternalError()
    {
        $response = ["success" => 0, "error" => ["message" => "Internal error"]];
        return json_encode($response);
    }
}

?>