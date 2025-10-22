<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroItem
{
    private $id = NULL;
    private $description = NULL;
    private $quantity = NULL;
    private $amount = NULL;
    private $weight = NULL;
    private $shippingCost = NULL;
    public function __construct($data = NULL)
    {
        if ($data) {
            if (isset($data["id"])) {
                $this->id = $data["id"];
            }
            if (isset($data["description"])) {
                $this->description = $data["description"];
            }
            if (isset($data["quantity"])) {
                $this->quantity = $data["quantity"];
            }
            if (isset($data["amount"])) {
                $this->amount = $data["amount"];
            }
            if (isset($data["weight"])) {
                $this->weight = $data["weight"];
            }
            if (isset($data["shippingCost"])) {
                $this->shippingCost = $data["shippingCost"];
            }
        }
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = PagSeguroHelper::formatString($description, 255);
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    public function getWeight()
    {
        return $this->weight;
    }
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
    public function getShippingCost()
    {
        return $this->shippingCost;
    }
    public function setShippingCost($shippingCost)
    {
        $this->shippingCost = $shippingCost;
    }
}

?>