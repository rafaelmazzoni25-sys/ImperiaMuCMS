<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroParameterItem
{
    private $key = NULL;
    private $value = NULL;
    private $group = NULL;
    public function __construct($key, $value, $group = NULL)
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
        $this->value = $value;
    }
    public function getGroup()
    {
        return $this->group;
    }
    public function setGroup($group)
    {
        $this->group = (array) $group;
    }
}

?>