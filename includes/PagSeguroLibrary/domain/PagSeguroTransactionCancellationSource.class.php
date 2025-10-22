<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroTransactionCancellationSource
{
    private $value = NULL;
    private static $sourceList = ["PAGSEGURO" => "INTERNAL", "FINANCEIRA" => "EXTERNAL"];
    public function __construct($value = NULL)
    {
        if ($value) {
            $this->value = $value;
        }
    }
    public static function getSourceList()
    {
        return self::$sourceList;
    }
    public function setByType($type)
    {
        if (isset(self::$sourceList[$type])) {
            $this->value = self::$sourceList[$type];
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
        return array_search($this->value, self::$sourceList);
    }
}

?>