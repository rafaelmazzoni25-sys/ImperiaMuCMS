<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
abstract class Paymentwall_ApiObject extends Paymentwall_Instance
{
    protected $brickSubEndpoints = [];
    const API_BRICK_SUBPATH = "brick";
    const API_OBJECT_CHARGE = "charge";
    const API_OBJECT_SUBSCRIPTION = "subscription";
    const API_OBJECT_ONE_TIME_TOKEN = "token";
    public abstract function getEndpointName();
    public function __construct($id = "")
    {
        if (!empty($id)) {
            $this->_id = $id;
        }
    }
    public final function create($params = [])
    {
        $httpAction = new Paymentwall_HttpAction($this, $params, [$this->getApiBaseHeader()]);
        $this->setPropertiesFromResponse($httpAction->run());
        return $this;
    }
    public function __get($property)
    {
        return isset($this->properties[$property]) ? $this->properties[$property] : NULL;
    }
    public function getApiUrl()
    {
        if ($this->getEndpointName() === "token" && !$this->getConfig()->isTest()) {
            return Paymentwall_OneTimeToken::GATEWAY_TOKENIZATION_URL;
        }
        return $this->getApiBaseUrl() . $this->getSubPath() . "/" . $this->getEndpointName();
    }
    public function _getPublicData()
    {
        $response = $this->getPropertiesFromResponse();
        $result = [];
        if (isset($response["type"]) && $response["type"] == "Error") {
            $result = ["success" => 0, "error" => ["message" => $response["error"], "code" => $response["code"]]];
        } else {
            if (!empty($response["secure"])) {
                $result = ["success" => 0, "secure" => $response["secure"]];
            } else {
                if ($this->isSuccessful()) {
                    $result["success"] = 1;
                } else {
                    $result = ["success" => 0, "error" => ["message" => "Internal error"]];
                }
            }
        }
        return $result;
    }
    public function getPublicData()
    {
        return json_encode($this->_getPublicData());
    }
    public function getProperties()
    {
        return $this->properties;
    }
    public function getRawResponseData()
    {
        return $this->_rawResponse;
    }
    protected function setPropertiesFromResponse($response = "")
    {
        if (!empty($response)) {
            $this->_rawResponse = $response;
            $this->properties = $easytoyou_decoder_beta_not_finish;
        } else {
            throw new Exception("Empty response");
        }
    }
    protected function getSubPath()
    {
        return in_array($this->getEndpointName(), $this->brickSubEndpoints) ? "/brick" : "";
    }
    protected function getPropertiesFromResponse()
    {
        return $this->properties;
    }
    protected function preparePropertiesFromResponse($string = "")
    {
        return json_decode($string, false);
    }
    protected function getApiBaseHeader()
    {
        return "X-ApiKey: " . $this->getPrivateKey();
    }
    protected function doApiAction($action = "", $method = "post")
    {
        $actionUrl = $this->getApiUrl() . "/" . $this->_id . "/" . $action;
        $httpAction = new Paymentwall_HttpAction($this, ["id" => $this->_id], [$this->getApiBaseHeader()]);
        $this->_responseLogInformation = $httpAction->getResponseLogInformation();
        $this->setPropertiesFromResponse($method == "get" ? $httpAction->get($actionUrl) : $httpAction->post($actionUrl));
        return $this;
    }
    public function getResponseLogInformation()
    {
        return $this->_responseLogInformation;
    }
}

?>