<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroSenderDocument
{
    private $type = NULL;
    private $value = NULL;
    public function __construct($type, $value)
    {
        if ($type && $value) {
            $this->setType($type);
            $this->setValue($value);
        }
    }
    public function getType()
    {
        return $this->type;
    }
    public function setType($type)
    {
        $this->type = strtoupper($type);
    }
    public function getValue()
    {
        return $this->value;
    }
    public function setValue($value)
    {
        $this->value = PagSeguroHelper::getOnlyNumbers($value);
    }
    public function toString()
    {
        $document = [];
        $document["type"] = $this->type;
        $document["value"] = $this->value;
        return "PagSeguroSenderDocument: " . var_export($document, true);
    }
}

?>