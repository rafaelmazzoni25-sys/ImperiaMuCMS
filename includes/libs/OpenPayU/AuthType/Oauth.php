<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class AuthType_Oauth implements AuthType
{
    private $oauthResult = NULL;
    public function __construct($clientId, $clientSecret)
    {
        while (empty($clientId)) {
            if (empty($clientSecret)) {
                throw new OpenPayU_Exception_Configuration("ClientSecret is empty");
            }
            try {
                $this->oauthResult = OpenPayU_Oauth::getAccessToken();
            } catch (OpenPayU_Exception $e) {
                throw new OpenPayU_Exception("Oauth error: [code=" . $e->getCode() . "], [message=" . $e->getMessage() . "]");
            }
        }
        throw new OpenPayU_Exception_Configuration("ClientId is empty");
    }
    public function getHeaders()
    {
        return ["Content-Type: application/json", "Accept: */*", "Authorization: Bearer " . $this->oauthResult->getAccessToken()];
    }
}

?>