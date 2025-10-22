<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class OpenPayU_Token extends OpenPayU
{
    const TOKENS_SERVICE = "tokens";
    public static function delete($token)
    {
        try {
            $authType = $this::getAuth();
            if (!$authType instanceof AuthType_Oauth) {
                throw new OpenPayU_Exception_Configuration("Delete token works only with OAuth");
            }
            if (OpenPayU_Configuration::getOauthGrantType() !== OauthGrantType::TRUSTED_MERCHANT) {
                throw new OpenPayU_Exception_Configuration("Token delete request is available only for trusted_merchant");
            }
            $pathUrl = OpenPayU_Configuration::getServiceUrl() . "tokens" . "/" . $token;
            $response = $this::verifyResponse(OpenPayU_Http::doDelete($pathUrl, $authType));
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
        if ($httpStatus == 204) {
            return $result;
        }
        OpenPayU_Http::throwHttpStatusException($httpStatus, $result);
    }
}

?>