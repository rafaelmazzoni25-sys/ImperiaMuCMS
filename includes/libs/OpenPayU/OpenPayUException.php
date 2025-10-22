<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class OpenPayU_Exception extends Exception
{
}
class OpenPayU_Exception_Request extends OpenPayU_Exception
{
    private $originalResponseMessage = NULL;
    public function __construct($originalResponseMessage, $message = "", $code = 0, $previous = NULL)
    {
        $this->originalResponseMessage = $originalResponseMessage;
        $this::__construct($message, $code, $previous);
    }
    public function getOriginalResponse()
    {
        return $this->originalResponseMessage;
    }
}
class OpenPayU_Exception_Configuration extends OpenPayU_Exception
{
}
class OpenPayU_Exception_Network extends OpenPayU_Exception
{
}
class OpenPayU_Exception_ServerError extends OpenPayU_Exception
{
}
class OpenPayU_Exception_ServerMaintenance extends OpenPayU_Exception
{
}
class OpenPayU_Exception_Authorization extends OpenPayU_Exception
{
}

?>