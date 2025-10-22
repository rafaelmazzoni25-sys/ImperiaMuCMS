<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Paymentwall_Charge extends Paymentwall_ApiObject implements Paymentwall_ApiObjectInterface
{
    public function getId()
    {
        return $this->id;
    }
    public function isTest()
    {
        return $this->test;
    }
    public function isSuccessful()
    {
        return $this->object == API_OBJECT_CHARGE;
    }
    public function isCaptured()
    {
        return $this->captured;
    }
    public function isUnderReview()
    {
        return $this->risk == "pending";
    }
    public function isRefunded()
    {
        return $this->refunded;
    }
    public function setPropertiesFromResponse($response = "")
    {
        $this::setPropertiesFromResponse($response);
        $this->card = new Paymentwall_Card($this->card);
    }
    public function getEndpointName()
    {
        return API_OBJECT_CHARGE;
    }
    public function getCard()
    {
        return new Paymentwall_Card($this->card);
    }
    public function get()
    {
        return $this->doApiAction("", "get");
    }
    public function refund()
    {
        return $this->doApiAction("refund");
    }
    public function capture()
    {
        return $this->doApiAction("capture");
    }
    public function void()
    {
        return $this->doApiAction("void");
    }
}

?>