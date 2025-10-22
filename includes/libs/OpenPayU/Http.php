<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class OpenPayU_Http
{
    public static function doPost($pathUrl, $data, $authType)
    {
        $response = OpenPayU_HttpCurl::doPayuRequest("POST", $pathUrl, $authType, $data);
        return $response;
    }
    public static function doGet($pathUrl, $authType)
    {
        $response = OpenPayU_HttpCurl::doPayuRequest("GET", $pathUrl, $authType);
        return $response;
    }
    public static function doDelete($pathUrl, $authType)
    {
        $response = OpenPayU_HttpCurl::doPayuRequest("DELETE", $pathUrl, $authType);
        return $response;
    }
    public static function doPut($pathUrl, $data, $authType)
    {
        $response = OpenPayU_HttpCurl::doPayuRequest("PUT", $pathUrl, $authType, $data);
        return $response;
    }
    public static function throwHttpStatusException($statusCode, $message = NULL)
    {
        $response = $message->getResponse();
        $statusDesc = isset($response->status->statusDesc) ? $response->status->statusDesc : "";
        switch ($statusCode) {
            case 400:
                throw new OpenPayU_Exception_Request($message, $message->getStatus() . " - " . $statusDesc, $statusCode);
                break;
            case 401:
                break;
            case 403:
                throw new OpenPayU_Exception_Authorization($message->getStatus() . " - " . $statusDesc, $statusCode);
                break;
            case 404:
                throw new OpenPayU_Exception_Network($message->getStatus() . " - " . $statusDesc, $statusCode);
                break;
            case 408:
                throw new OpenPayU_Exception_ServerError("Request timeout", $statusCode);
                break;
            case 500:
                throw new OpenPayU_Exception_ServerError("PayU system is unavailable or your order is not processed.\n                Error:\n                [" . $statusDesc . "]", $statusCode);
                break;
            case 503:
                throw new OpenPayU_Exception_ServerMaintenance("Service unavailable", $statusCode);
                break;
            default:
                throw new OpenPayU_Exception_Network("Unexpected HTTP code response", $statusCode);
        }
    }
    public static function throwErrorHttpStatusException($statusCode, $resultError)
    {
        switch ($statusCode) {
            case 400:
                throw new OpenPayU_Exception($resultError->getError() . " - " . $resultError->getErrorDescription(), $statusCode);
                break;
            case 401:
                break;
            case 403:
                throw new OpenPayU_Exception_Authorization($resultError->getError() . " - " . $resultError->getErrorDescription(), $statusCode);
                break;
            case 404:
                throw new OpenPayU_Exception_Network($resultError->getError() . " - " . $resultError->getErrorDescription(), $statusCode);
                break;
            case 408:
                throw new OpenPayU_Exception_ServerError("Request timeout", $statusCode);
                break;
            case 500:
                throw new OpenPayU_Exception_ServerError("PayU system is unavailable. Error: [" . $resultError->getErrorDescription() . "]", $resultError);
                break;
            case 503:
                throw new OpenPayU_Exception_ServerMaintenance("Service unavailable", $statusCode);
                break;
            default:
                throw new OpenPayU_Exception_Network("Unexpected HTTP code response", $statusCode);
        }
    }
}

?>