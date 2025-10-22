<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Interkassa_Shop
{
    protected $_secret_key = NULL;
    public static function factory($options)
    {
        return new Interkassa_Shop($options);
    }
    public function __construct($options)
    {
        if (!isset($options["id"])) {
            throw new Interkassa_Exception("Shop id is required");
        }
        if (!isset($options["secret_key"])) {
            throw new Interkassa_Exception("Secret key is required");
        }
        $this->_id = $options["id"];
        $this->_secret_key = $options["secret_key"];
    }
    public function createPayment($data)
    {
        return Interkassa_Payment::factory($this, $data);
    }
    public function receiveStatus($source = NULL)
    {
        if ($source == NULL) {
            $source = $_REQUEST;
        }
        return Interkassa_Status::factory($this, $source);
    }
    public function getId()
    {
        return $this->_id;
    }
    public function getSecretKey()
    {
        return $this->_secret_key;
    }
}

?>