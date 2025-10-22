<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class OpenPayU_Retrieve extends OpenPayU
{
    const PAYMETHODS_SERVICE = "paymethods";
    public static function payMethods($lang = NULL)
    {
        try {
            $authType = $this::getAuth();
            if (!$authType instanceof AuthType_Oauth) {
                throw new OpenPayU_Exception_Configuration("Retrieve works only with OAuth");
            }
            $pathUrl = OpenPayU_Configuration::getServiceUrl() . "paymethods";
            if ($lang !== NULL) {
                $pathUrl .= "?lang=" . $lang;
            }
            $response = $this::verifyResponse(OpenPayU_Http::doGet($pathUrl, $authType));
            return $response;
        } catch (OpenPayU_Exception $e) {
            throw new OpenPayU_Exception($e->getMessage(), $e->getCode());
        }
    }
    public static function verifyResponse($response)
    {
        $data = [];
        $httpStatus = $response["code"];
        $message = OpenPayU_Util::convertJsonToArray($response["response"], true);
        $data["status"] = isset($message["status"]["statusCode"]) ? $message["status"]["statusCode"] : NULL;
        if (json_last_error() == JSON_ERROR_SYNTAX) {
            $data["response"] = $response["response"];
        } else {
            if (isset($message)) {
                $data["response"] = $message;
                unset($message["status"]);
            }
        }
        $result = $this::build($data);
        if ($httpStatus == 200 || $httpStatus == 201 || $httpStatus == 422 || $httpStatus == 302 || $httpStatus == 400 || $httpStatus == 404) {
            return $result;
        }
        OpenPayU_Http::throwHttpStatusException($httpStatus, $result);
    }
}

?>