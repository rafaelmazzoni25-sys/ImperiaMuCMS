<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class AuthType_Basic implements AuthType
{
    private $authBasicToken = NULL;
    public function __construct($posId, $signatureKey)
    {
        if (empty($posId)) {
            throw new OpenPayU_Exception_Configuration("PosId is empty");
        }
        if (empty($signatureKey)) {
            throw new OpenPayU_Exception_Configuration("SignatureKey is empty");
        }
        $this->authBasicToken = base64_encode($posId . ":" . $signatureKey);
    }
    public function getHeaders()
    {
        return ["Content-Type: application/json", "Accept: application/json", "Authorization: Basic " . $this->authBasicToken];
    }
}

?>