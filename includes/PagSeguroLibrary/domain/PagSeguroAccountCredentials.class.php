<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroAccountCredentials extends PagSeguroCredentials
{
    private $email = NULL;
    private $token = NULL;
    public function __construct($email, $token)
    {
        if ($email !== NULL && $token !== NULL) {
            $this->email = $email;
            $this->token = $token;
        } else {
            throw new Exception("Credentials not set.");
        }
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getToken()
    {
        return $this->token;
    }
    public function setToken($token)
    {
        $this->token = $token;
    }
    public function getAttributesMap()
    {
        return ["email" => $this->email, "token" => $this->token];
    }
    public function toString()
    {
        $credentials = [];
        $credentials["E-mail"] = $this->email;
        $credentials["Token"] = $this->token;
        return implode(" - ", $credentials);
    }
}

?>