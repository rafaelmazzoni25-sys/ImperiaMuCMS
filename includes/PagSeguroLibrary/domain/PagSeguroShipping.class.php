<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroShipping
{
    private $address = NULL;
    private $type = NULL;
    private $cost = NULL;
    public function __construct($data = NULL)
    {
        if ($data) {
            if (isset($data["address"]) && $data["address"] instanceof PagSeguroAddress) {
                $this->address = $data["address"];
            }
            if (isset($data["type"]) && $data["type"] instanceof PagSeguroShippingType) {
                $this->type = $data["type"];
            }
            if (isset($data["cost"])) {
                $this->cost = $data["cost"];
            }
        }
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress(PagSeguroAddress $address)
    {
        $this->address = $address;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setType(PagSeguroShippingType $type)
    {
        $this->type = $type;
    }
    public function getCost()
    {
        return $this->cost;
    }
    public function setCost($cost)
    {
        $this->cost = $cost;
    }
}

?>