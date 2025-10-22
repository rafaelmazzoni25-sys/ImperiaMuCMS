<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class ResultError
{
    private $error = NULL;
    private $errorDescription = NULL;
    public function getError()
    {
        return $this->error;
    }
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }
    public function getErrorDescription()
    {
        return $this->errorDescription;
    }
    public function setErrorDescription($errorDescription)
    {
        $this->errorDescription = $errorDescription;
        return $this;
    }
}

?>