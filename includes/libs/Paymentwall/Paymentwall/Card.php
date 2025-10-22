<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Paymentwall_Card
{
    protected $fields = [];
    public function __construct($details = [])
    {
        $this->fields = $easytoyou_decoder_beta_not_finish;
    }
    public function __get($property)
    {
        return isset($this->fields[$property]) ? $this->fields[$property] : NULL;
    }
    public function getToken()
    {
        return $this->token;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getAlias()
    {
        return $this->last4;
    }
    public function getMonthExpirationDate()
    {
        return $this->exp_month;
    }
    public function getYearExpirationDate()
    {
        return $this->exp_year;
    }
}

?>