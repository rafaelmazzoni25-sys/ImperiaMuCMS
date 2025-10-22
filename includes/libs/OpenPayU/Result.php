<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class OpenPayU_Result
{
    private $status = "";
    private $error = "";
    private $success = 0;
    private $request = "";
    private $response = "";
    private $sessionId = "";
    private $message = "";
    private $countryCode = "";
    private $reqId = "";
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($value)
    {
        $this->status = $value;
    }
    public function getError()
    {
        return $this->error;
    }
    public function setError($value)
    {
        $this->error = $value;
    }
    public function getSuccess()
    {
        return $this->success;
    }
    public function setSuccess($value)
    {
        $this->success = $value;
    }
    public function getRequest()
    {
        return $this->request;
    }
    public function setRequest($value)
    {
        $this->request = $value;
    }
    public function getResponse()
    {
        return $this->response;
    }
    public function setResponse($value)
    {
        $this->response = $value;
    }
    public function getSessionId()
    {
        return $this->sessionId;
    }
    public function setSessionId($value)
    {
        $this->sessionId = $value;
    }
    public function getMessage()
    {
        return $this->message;
    }
    public function setMessage($value)
    {
        $this->message = $value;
    }
    public function getCountryCode()
    {
        return $this->countryCode;
    }
    public function setCountryCode($value)
    {
        $this->countryCode = $value;
    }
    public function getReqId()
    {
        return $this->reqId;
    }
    public function setReqId($value)
    {
        $this->reqId = $value;
    }
    public function init($attributes)
    {
        $attributes = OpenPayU_Util::parseArrayToObject($attributes);
        if (!empty($attributes)) {
            foreach ($attributes as $name => $value) {
                $this->set($name, $value);
            }
        }
    }
    public function set($name, $value)
    {
        $this->{$name} = $value;
    }
    public function __get($name)
    {
        if (isset($this->{$name})) {
            return $this->name;
        }
        return NULL;
    }
    public function __call($methodName, $args)
    {
        if (preg_match("~^(set|get)([A-Z])(.*)\$~", $methodName, $matches)) {
            $property = strtolower($matches[2]) . $matches[3];
            if (!property_exists($this, $property)) {
                throw new Exception("Property " . $property . " not exists");
            }
            switch ($matches[1]) {
                case "get":
                    $this->checkArguments($args, 0, 0, $methodName);
                    return $this->get($property);
                    break;
                case "default":
                    throw new Exception("Method " . $methodName . " not exists");
                    break;
            }
        }
    }
}

?>