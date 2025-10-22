<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroTransactionType
{
    private $value = NULL;
    private static $typeList = ["PAYMENT" => 1, "TRANSFER" => 2, "FUND_ADDITION" => 3, "WITHDRAW" => 4, "CHARGE" => 5, "DONATION" => 6, "BONUS" => 7, "BONUS_REPASS" => 8, "OPERATIONAL" => 9, "POLITICAL_DONATION" => 10];
    public function __construct($value = NULL)
    {
        if ($value) {
            $this->value = $value;
        }
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
        $value = $value == NULL ? $this->value : $value;
        return array_search($value, self::$typeList);
    }
}

?>