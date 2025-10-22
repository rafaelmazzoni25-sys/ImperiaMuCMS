<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Paymentwall_Response_Factory
{
    const CLASS_NAME_PREFIX = "Paymentwall_Response_";
    const RESPONSE_SUCCESS = "success";
    const RESPONSE_ERROR = "error";
    public static function get($response = [])
    {
        $responseModel = NULL;
        $responseModel = $this::getClassName($response);
        return new $responseModel($response);
    }
    public static function getClassName($response = [])
    {
        $responseType = isset($response["type"]) && $response["type"] == "Error" ? "error" : "success";
        return "Paymentwall_Response_" . ucfirst($responseType);
    }
}

?>