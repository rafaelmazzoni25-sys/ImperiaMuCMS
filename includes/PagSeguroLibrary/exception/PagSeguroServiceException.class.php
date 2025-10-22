<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroServiceException extends Exception
{
    private $httpStatus = NULL;
    private $httpMessage = NULL;
    private $errors = [];
    public function __construct(PagSeguroHttpStatus $httpStatus, $errors = NULL)
    {
        $this->httpStatus = $httpStatus;
        if ($errors) {
            $this->errors = $errors;
        }
        $this::__construct($this->getOneLineMessage());
    }
    public function getOneLineMessage()
    {
        return str_replace("\n", " ", $this->getFormattedMessage());
    }
    public function getFormattedMessage()
    {
        $message = "";
        $message .= "[HTTP " . $this->httpStatus->getStatus() . "] - " . $this->getHttpMessage() . "\n";
        foreach ($this->errors as $key => $value) {
            if ($value instanceof PagSeguroError) {
                $message .= $key . " [" . $value->getCode() . "] - " . $value->getMessage();
            }
        }
        return $message;
    }
    private function getHttpMessage()
    {
        $this->httpStatus->getType();
        switch ($type = $this->httpStatus->getType()) {
            case "BAD_REQUEST":
                break;
            case "UNAUTHORIZED":
                break;
            case "FORBIDDEN":
                break;
            case "NOT_FOUND":
                break;
            case "INTERNAL_SERVER_ERROR":
                break;
            case "BAD_GATEWAY":
                $message = $type;
                break;
            default:
                $message = "UNDEFINED";
                return $message;
        }
    }
    public function getErrors()
    {
        return $this->errors;
    }
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }
    public function setHttpStatus(PagSeguroHttpStatus $httpStatus)
    {
        $this->httpStatus = $httpStatus;
    }
}

?>