<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class OpenPayU_HttpCurl
{
    public static $headers = NULL;
    public static function doPayuRequest($requestType, $pathUrl, $auth, $data = NULL)
    {
        if (empty($pathUrl)) {
            throw new OpenPayU_Exception_Configuration("The endpoint is empty");
        }
        $ch = curl_init($pathUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requestType);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $auth->getHeaders());
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, "OpenPayU_HttpCurl::readHeader");
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        if ($proxy = $this::getProxy()) {
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
            if ($proxyAuth = $this::getProxyAuth()) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
            }
        }
        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($response === false) {
            throw new OpenPayU_Exception_Network(curl_error($ch));
        }
        curl_close($ch);
        return ["code" => $httpStatus, "response" => trim($response)];
    }
    public static function getSignature($headers)
    {
        foreach ($headers as $name => $value) {
            if (preg_match("/X-OpenPayU-Signature/i", $name) || preg_match("/OpenPayu-Signature/i", $name)) {
                return $value;
            }
        }
        return NULL;
    }
    public static function readHeader($ch, $header)
    {
        if (preg_match("/([^:]+): (.+)/m", $header, $match)) {
            self::$headers[$match[1]] = trim($match[2]);
        }
        return strlen($header);
    }
    private static function getProxy()
    {
        return OpenPayU_Configuration::getProxyHost() != NULL ? OpenPayU_Configuration::getProxyHost() . (OpenPayU_Configuration::getProxyPort() ? ":" . OpenPayU_Configuration::getProxyPort() : "") : false;
    }
    private static function getProxyAuth()
    {
        return OpenPayU_Configuration::getProxyUser() != NULL ? OpenPayU_Configuration::getProxyUser() . (OpenPayU_Configuration::getProxyPassword() ? ":" . OpenPayU_Configuration::getProxyPassword() : "") : false;
    }
}

?>