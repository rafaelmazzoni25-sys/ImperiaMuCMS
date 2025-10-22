<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroDocument
{
    private $type = NULL;
    private $value = NULL;
    private static $availableDocumentList = ["1" => "CPF"];
    public function __construct($data = NULL)
    {
        if ($data && isset($data["type"]) && isset($data["value"])) {
            $this->setType($data["type"]);
            $this->setValue(PagSeguroHelper::getOnlyNumbers($data["value"]));
        }
    }
    public static function isDocumentTypeAvailable($documentType)
    {
        return array_search(strtoupper($documentType), self::$availableDocumentList);
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
        $this->value = $value;
    }
}

?>