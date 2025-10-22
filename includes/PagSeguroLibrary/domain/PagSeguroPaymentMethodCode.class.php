<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroPaymentMethodCode
{
    private $value = NULL;
    private static $codeList = ["VISA_CREDIT_CARD" => 101, "MASTERCARD_CREDIT_CARD" => 102, "AMEX_CREDIT_CARD" => 103, "DINERS_CREDIT_CARD" => 104, "HIPERCARD_CREDIT_CARD" => 105, "AURA_CREDIT_CARD" => 106, "ELO_CREDIT_CARD" => 107, "PLENOCARD_CREDIT_CARD" => 108, "PERSONALCARD_CREDIT_CARD" => 109, "JCB_CREDIT_CARD" => 110, "DISCOVER_CREDIT_CARD" => 111, "BRASILCARD_CREDIT_CARD" => 112, "FORTBRASIL_CREDIT_CARD" => 113, "CARDBAN_CREDIT_CARD" => 114, "VALECARD_CREDIT_CARD" => 115, "CABAL_CREDIT_CARD" => 116, "MAIS_CREDIT_CARD" => 117, "AVISTA_CREDIT_CARD" => 118, "GRANDCARD_CREDIT_CARD" => 119, "BRADESCO_BOLETO" => 201, "SANTANDER_BOLETO" => 202, "BRADESCO_ONLINE_TRANSFER" => 301, "ITAU_ONLINE_TRANSFER" => 302, "UNIBANCO_ONLINE_TRANSFER" => 303, "BANCO_BRASIL_ONLINE_TRANSFER" => 304, "REAL_ONLINE_TRANSFER" => 305, "BANRISUL_ONLINE_TRANSFER" => 306, "HSBC_ONLINE_TRANSFER" => 307, "PS_BALANCE" => 401, "OI_PAGGO" => 501, "BANCO_BRASIL_DIRECT_DEPOSIT" => 701];
    public function __construct($value = NULL)
    {
        if ($value) {
            $this->value = $value;
        }
    }
    public function setByType($type)
    {
        if (isset(self::$codeList[$type])) {
            $this->value = self::$codeList[$type];
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
        return array_search($value, self::$codeList);
    }
}

?>