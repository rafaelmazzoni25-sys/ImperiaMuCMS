<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroShippingType
{
    private $value = NULL;
    private static $typeList = ["PAC" => 1, "SEDEX" => 2, "NOT_SPECIFIED" => 3];
    public function __construct($value = NULL)
    {
        if ($value) {
            $this->value = $value;
        }
    }
    public static function getCodeByType($type)
    {
        if (isset(self::$typeList[$type])) {
            return self::$typeList[$type];
        }
        return false;
    }
    public static function createByType($type)
    {
        $ShippingType = new PagSeguroShippingType();
        $ShippingType->setByType($type);
        return $ShippingType;
    }
    public function setByType($type)
    {
        if (isset(self::$typeList[$type])) {
            $this->value = self::$typeList[$type];
        } else {
            throw new Exception("undefined index " . $type);
        }
    }
    public function getValue()
    {
        return $this->value;
    }
    public function setValue($value)
    {
        $this->value = $value;
    }
    public function getTypeFromValue($value = NULL)
    {
        $value = $value === NULL ? $this->value : $value;
        return array_search($value, self::$typeList);
    }
}

?>