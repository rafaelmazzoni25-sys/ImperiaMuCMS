<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroHttpConnection
{
    private $status = NULL;
    private $response = NULL;
    public function __construct()
    {
        if (!function_exists("curl_init")) {
            throw new Exception("PagSeguroLibrary: cURL library is required.");
        }
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getResponse()
    {
        return $this->response;
    }
    public function setResponse($response)
    {
        $this->response = $response;
    }
    public function post($url, $data, $timeout = 20, $charset = "ISO-8859-1")
    {
        return $this->curlConnection("POST", $url, $timeout, $charset, $data);
    }
    private function curlConnection($method, $url, $timeout, $charset, $data = NULL)
    {
        if (strtoupper($method) === "POST") {
            $postFields = $data ? http_build_query($data, "", "&") : "";
            $contentLength = "Content-length: " . strlen($postFields);
            $methodOptions = [CURLOPT_POST => true, CURLOPT_POSTFIELDS => $postFields];
        } else {
            $contentLength = NULL;
            $methodOptions = [CURLOPT_HTTPGET => true];
        }
        $options = [CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded; charset=" . $charset, $contentLength, "lib-description: php:" . PagSeguroLibrary::getVersion(), "language-engine-description: php:" . PagSeguroLibrary::getPHPVersion()], CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true, CURLOPT_HEADER => false, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_CONNECTTIMEOUT => $timeout];
        if (!is_null(PagSeguroLibrary::getModuleVersion())) {
            array_push($options[CURLOPT_HTTPHEADER], "module-description: " . PagSeguroLibrary::getModuleVersion());
        }
        if (!is_null(PagSeguroLibrary::getCMSVersion())) {
            array_push($options[CURLOPT_HTTPHEADER], "cms-description: " . PagSeguroLibrary::getCMSVersion());
        }
        $options = $options + $methodOptions;
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $resp = curl_exec($curl);
        $info = curl_getinfo($curl);
        $error = curl_errno($curl);
        $errorMessage = curl_error($curl);
        curl_close($curl);
        $this->setStatus((array) $info["http_code"]);
        $this->setResponse((string) $resp);
        if ($error) {
            throw new Exception("CURL can't connect: " . $errorMessage);
        }
        return true;
    }
    public function get($url, $timeout = 20, $charset = "ISO-8859-1")
    {
        return $this->curlConnection("GET", $url, $timeout, $charset, NULL);
    }
}

?>