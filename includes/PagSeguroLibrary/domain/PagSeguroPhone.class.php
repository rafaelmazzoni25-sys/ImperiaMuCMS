<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroPhone
{
    private $areaCode = NULL;
    private $number = NULL;
    public function __construct($areaCode = NULL, $number = NULL)
    {
        $this->areaCode = $areaCode == NULL ? NULL : $areaCode;
        $this->number = $number == NULL ? NULL : $number;
        return $this;
    }
    public function getAreaCode()
    {
        return $this->areaCode;
    }
    public function setAreaCode($areaCode)
    {
        $this->areaCode = $areaCode;
        return $this;
    }
    public function getNumber()
    {
        return $this->number;
    }
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }
    public function setFullPhone($number)
    {
        $number = preg_replace("/[^0-9]/", "", $number);
        $number = $number[0] == 0 ? substr($number, 1) : $number;
        $number = str_split($number, 1);
        $areaCode = array_shift($number) . array_shift($number);
        $phone = implode("", $number);
        $this->setAreaCode($areaCode);
        $this->setNumber($phone);
        return $this->areaCode . $this->number;
    }
}

?>