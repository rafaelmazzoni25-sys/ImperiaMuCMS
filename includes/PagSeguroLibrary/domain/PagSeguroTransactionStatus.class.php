<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroTransactionStatus
{
    private $value = NULL;
    private static $statusList = ["INITIATED" => 0, "WAITING_PAYMENT" => 1, "IN_ANALYSIS" => 2, "PAID" => 3, "AVAILABLE" => 4, "IN_DISPUTE" => 5, "REFUNDED" => 6, "CANCELLED" => 7];
    public function __construct($value = NULL)
    {
        if ($value) {
            $this->value = $value;
        }
    }
    public static function getStatusList()
    {
        return self::$statusList;
    }
    public function setByType($type)
    {
        if (isset(self::$statusList[$type])) {
            $this->value = self::$statusList[$type];
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
        return array_search($this->value, self::$statusList);
    }
}

?>