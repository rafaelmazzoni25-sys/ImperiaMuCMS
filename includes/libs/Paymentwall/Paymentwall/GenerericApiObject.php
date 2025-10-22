<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Paymentwall_GenerericApiObject extends Paymentwall_ApiObject
{
    protected $httpAction = NULL;
    public function getEndpointName()
    {
        return $this->api;
    }
    public function __construct($type)
    {
        $this->api = $type;
        $this->httpAction = new Paymentwall_HttpAction($this);
    }
    public function post($params = [], $headers = [])
    {
        if (empty($params)) {
            return NULL;
        }
        $this->httpAction->setApiParams($params);
        $this->httpAction->setApiHeaders(array_merge([$this->getApiBaseHeader()], $headers));
        return $easytoyou_decoder_beta_not_finish;
    }
}

?>