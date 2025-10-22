<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroMetaDataItem
{
    private $key = NULL;
    private $value = NULL;
    private $group = NULL;
    public function __construct($key = NULL, $value = NULL, $group = NULL)
    {
        if (isset($key) && !PagSeguroHelper::isEmpty($key)) {
            $this->setKey($key);
        }
        if (isset($value) && !PagSeguroHelper::isEmpty($value)) {
            $this->setValue($value);
        }
        if (isset($group) && !PagSeguroHelper::isEmpty($group)) {
            $this->setGroup($group);
        }
    }
    public function getKey()
    {
        return $this->key;
    }
    public function setKey($key)
    {
        $this->key = $key;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function setValue($value)
    {
        $this->value = $this->normalizeParameter($value);
    }
    public function getGroup()
    {
        return $this->group;
    }
    public function setGroup($group)
    {
        $this->group = (array) $group;
    }
    private function normalizeParameter($parameterValue)
    {
        $parameterValue = PagSeguroHelper::formatString($parameterValue, 100, "");
        $this->getKey();
        switch ($this->getKey()) {
            case PagSeguroMetaDataItemKeys::getItemKeyByDescription("CPF do passageiro"):
                $parameterValue = PagSeguroHelper::getOnlyNumbers($parameterValue);
                break;
            case PagSeguroMetaDataItemKeys::getItemKeyByDescription("Tempo no jogo em dias"):
                $parameterValue = PagSeguroHelper::getOnlyNumbers($parameterValue);
                break;
            case PagSeguroMetaDataItemKeys::getItemKeyByDescription("Celular de recarga"):
                break;
            default:
                return $parameterValue;
        }
    }
}

?>