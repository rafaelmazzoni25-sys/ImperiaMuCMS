<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class OpenPayU_Oauth
{
    private static $oauthTokenCache = NULL;
    const CACHE_KEY = "AccessToken";
    public static function getAccessToken($clientId = NULL, $clientSecret = NULL)
    {
        if (OpenPayU_Configuration::getOauthGrantType() === OauthGrantType::TRUSTED_MERCHANT) {
            return $this::retrieveAccessToken($clientId, $clientSecret);
        }
        $cacheKey = "AccessToken" . OpenPayU_Configuration::getOauthClientId();
        $this::getOauthTokenCache();
        $tokenCache = self::$oauthTokenCache->get($cacheKey);
        if ($tokenCache instanceof OauthResultClientCredentials && !$tokenCache->hasExpire()) {
            return $tokenCache;
        }
        self::$oauthTokenCache->invalidate($cacheKey);
        $response = $this::retrieveAccessToken($clientId, $clientSecret);
        self::$oauthTokenCache->set($cacheKey, $response);
        return $response;
    }
    private static function retrieveAccessToken($clientId, $clientSecret)
    {
        $authType = new AuthType_TokenRequest();
        $oauthUrl = OpenPayU_Configuration::getOauthEndpoint();
        $data = ["grant_type" => OpenPayU_Configuration::getOauthGrantType(), "client_id" => $clientId ? $clientId : OpenPayU_Configuration::getOauthClientId(), "client_secret" => $clientSecret ? $clientSecret : OpenPayU_Configuration::getOauthClientSecret()];
        if (OpenPayU_Configuration::getOauthGrantType() === OauthGrantType::TRUSTED_MERCHANT) {
            $data["email"] = OpenPayU_Configuration::getOauthEmail();
            $data["ext_customer_id"] = OpenPayU_Configuration::getOauthExtCustomerId();
        }
        return $this::parseResponse(OpenPayU_Http::doPost($oauthUrl, http_build_query($data, "", "&"), $authType));
    }
    private static function parseResponse($response)
    {
        $httpStatus = $response["code"];
        if ($httpStatus == 500) {
            $result = new ResultError();
            $result->setErrorDescription($response["response"]);
            OpenPayU_Http::throwErrorHttpStatusException($httpStatus, $result);
        }
        $message = OpenPayU_Util::convertJsonToArray($response["response"], true);
        if (json_last_error() == JSON_ERROR_SYNTAX) {
            throw new OpenPayU_Exception_ServerError("Incorrect json response. Response: [" . $response["response"] . "]");
        }
        if ($httpStatus == 200) {
            $result = new OauthResultClientCredentials();
            $result->setAccessToken($message["access_token"])->setTokenType($message["token_type"])->setExpiresIn($message["expires_in"])->setGrantType($message["grant_type"])->calculateExpireDate(new DateTime());
            return $result;
        }
        $result = new ResultError();
        $result->setError($message["error"])->setErrorDescription($message["error_description"]);
        OpenPayU_Http::throwErrorHttpStatusException($httpStatus, $result);
    }
    private static function getOauthTokenCache()
    {
        $oauthTokenCache = OpenPayU_Configuration::getOauthTokenCache();
        if (!$oauthTokenCache instanceof OauthCacheInterface) {
            $oauthTokenCache = new OauthCacheFile();
            OpenPayU_Configuration::setOauthTokenCache($oauthTokenCache);
        }
        self::$oauthTokenCache = $oauthTokenCache;
    }
}

?>