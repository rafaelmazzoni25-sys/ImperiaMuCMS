<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class OauthResultClientCredentials
{
    private $accessToken = NULL;
    private $tokenType = NULL;
    private $expiresIn = NULL;
    private $grantType = NULL;
    private $expireDate = NULL;
    public function getAccessToken()
    {
        return $this->accessToken;
    }
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }
    public function getTokenType()
    {
        return $this->tokenType;
    }
    public function setTokenType($tokenType)
    {
        $this->tokenType = $tokenType;
        return $this;
    }
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }
    public function setExpiresIn($expiresIn)
    {
        $this->expiresIn = $expiresIn;
        return $this;
    }
    public function getGrantType()
    {
        return $this->grantType;
    }
    public function setGrantType($grantType)
    {
        $this->grantType = $grantType;
        return $this;
    }
    public function getExpireDate()
    {
        return $this->expireDate;
    }
    public function calculateExpireDate($date)
    {
        $this->expireDate = $date->add(new DateInterval("PT" . ($this->expiresIn - 60) . "S"));
    }
    public function hasExpire()
    {
        return $this->expireDate <= new DateTime();
    }
}

?>