<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroAddress
{
    private $postalCode = NULL;
    private $street = NULL;
    private $number = NULL;
    private $complement = NULL;
    private $district = NULL;
    private $city = NULL;
    private $state = NULL;
    private $country = NULL;
    private static $acronyms = ["acre" => "AC", "alagoas" => "AL", "amapa" => "AP", "amazonas" => "AM", "bahia" => "BA", "ceara" => "CE", "espiritosanto" => "ES", "goias" => "GO", "maranhao" => "MA", "matogrosso" => "MT", "matogrossodosul" => "MS", "matogrossosul" => "MS", "minasgerais" => "MG", "para" => "PA", "paraiba" => "PB", "parana" => "PR", "pernambuco" => "PE", "piaui" => "PI", "riodejaneiro" => "RJ", "riojaneiro" => "RJ", "riograndedonorte" => "RN", "riograndenorte" => "RN", "riograndedosul" => "RS", "riograndesul" => "RS", "rondonia" => "RO", "roraima" => "RR", "santacatarina" => "SC", "saopaulo" => "SP", "sergipe" => "SE", "tocantins" => "TO", "distritofederal" => "DF"];
    public function __construct($data = NULL)
    {
        if (isset($data["postalCode"])) {
            $this->postalCode = $data["postalCode"];
        }
        if (isset($data["street"])) {
            $this->street = $data["street"];
        }
        if (isset($data["number"])) {
            $this->number = $data["number"];
        }
        if (isset($data["complement"])) {
            $this->complement = $data["complement"];
        }
        if (isset($data["district"])) {
            $this->district = $data["district"];
        }
        if (isset($data["city"])) {
            $this->city = $data["city"];
        }
        if (isset($data["state"])) {
            $this->state = $data["state"];
        }
        if (isset($data["country"])) {
            $this->country = $data["country"];
        }
    }
    public function getStreet()
    {
        return $this->street;
    }
    public function setStreet($street)
    {
        $this->street = $street;
    }
    public function getNumber()
    {
        return $this->number;
    }
    public function setNumber($number)
    {
        $this->number = $number;
    }
    public function getComplement()
    {
        return $this->complement;
    }
    public function setComplement($complement)
    {
        $this->complement = $complement;
    }
    public function getDistrict()
    {
        return $this->district;
    }
    public function setDistrict($district)
    {
        $this->district = $district;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }
    public function getState()
    {
        return $this->state;
    }
    public function setState($state)
    {
        $this->state = $this->treatState($state);
    }
    private function treatState($defaultState)
    {
        if (strlen($defaultState) == 2) {
            foreach (self::$acronyms as $key => $val) {
                if ($val == strtoupper($defaultState)) {
                    return strtoupper($defaultState);
                }
            }
            return "";
        } else {
            $state = utf8_decode($defaultState);
            $state = strtolower($state);
            $ascii["a"] = range(224, 230);
            $ascii["e"] = range(232, 235);
            $ascii["i"] = range(236, 239);
            $ascii["o"] = array_merge(range(242, 246), [240, 248]);
            $ascii["u"] = range(249, 252);
            $ascii["b"] = [223];
            $ascii["c"] = [231];
            $ascii["d"] = [208];
            $ascii["n"] = [241];
            $ascii["y"] = [253, 255];
            foreach ($ascii as $key => $item) {
                $accents = "";
                foreach ($item as $code) {
                    $accents .= chr($code);
                }
                $change[$key] = "/[" . $accents . "]/i";
            }
            $state = preg_replace(array_values($change), array_keys($change), $state);
            $state = preg_replace("/\\s/", "", $state);
            foreach (self::$acronyms as $key => $val) {
                if ($key == $state) {
                    $acronym = $val;
                    return $acronym;
                }
            }
            return "";
        }
    }
    public function getPostalCode()
    {
        return $this->postalCode;
    }
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }
    public function getCountry()
    {
        return $this->country;
    }
    public function setCountry($country)
    {
        $this->country = $country;
    }
}

?>