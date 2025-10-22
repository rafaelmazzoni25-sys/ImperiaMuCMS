<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroPaymentMethod
{
    private $type = NULL;
    private $code = NULL;
    public function __construct($type = NULL, $code = NULL)
    {
        if ($type) {
            $this->setType($type);
        }
        if ($code) {
            $this->setCode($code);
        }
    }
    public function getType()
    {
        return $this->type;
    }
    public function setType($type)
    {
        if ($type instanceof PagSeguroPaymentMethodType) {
            $this->type = $type;
        } else {
            $this->type = new PagSeguroPaymentMethodType($type);
        }
    }
    public function getCode()
    {
        return $this->code;
    }
    public function setCode($code)
    {
        if ($code instanceof PagSeguroPaymentMethodCode) {
            $this->code = $code;
        } else {
            $this->code = new PagSeguroPaymentMethodCode($code);
        }
    }
}

?>