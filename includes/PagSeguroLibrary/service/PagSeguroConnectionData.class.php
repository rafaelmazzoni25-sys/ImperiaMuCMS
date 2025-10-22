<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroConnectionData
{
    private $serviceName = NULL;
    private $credentials = NULL;
    private $resources = NULL;
    private $environment = NULL;
    private $webserviceUrl = NULL;
    private $paymentUrl = NULL;
    private $servicePath = NULL;
    private $serviceTimeout = NULL;
    private $charset = NULL;
    public function __construct(PagSeguroCredentials $credentials, $serviceName)
    {
        $this->credentials = $credentials;
        $this->serviceName = $serviceName;
        $this->setEnvironment(PagSeguroConfig::getEnvironment());
        $this->setWebserviceUrl(PagSeguroResources::getWebserviceUrl($this->getEnvironment()));
        $this->setPaymentUrl(PagSeguroResources::getPaymentUrl($this->getEnvironment()));
        $this->setCharset(PagSeguroConfig::getApplicationCharset());
        $this->resources = PagSeguroResources::getData($this->serviceName);
        if (isset($this->resources["servicePath"])) {
            $this->setServicePath($this->resources["servicePath"]);
        }
        if (isset($this->resources["serviceTimeout"])) {
            $this->setServiceTimeout($this->resources["serviceTimeout"]);
        }
    }
    public function getEnvironment()
    {
        return $this->environment;
    }
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }
    public function getCredentials()
    {
        return $this->credentials;
    }
    public function setCredentials(PagSeguroCredentials $credentials)
    {
        $this->credentials = $credentials;
    }
    public function getCredentialsUrlQuery()
    {
        return http_build_query($this->credentials->getAttributesMap(), "", "&");
    }
    public function getPaymentUrl()
    {
        return $this->paymentUrl;
    }
    public function setPaymentUrl($paymentUrl)
    {
        $this->paymentUrl = $paymentUrl;
    }
    public function getServiceTimeout()
    {
        return $this->serviceTimeout;
    }
    public function setServiceTimeout($serviceTimeout)
    {
        $this->serviceTimeout = $serviceTimeout;
    }
    public function getServiceUrl()
    {
        return $this->getWebserviceUrl() . $this->getServicePath();
    }
    public function getWebserviceUrl()
    {
        return $this->webserviceUrl;
    }
    public function setWebserviceUrl($webserviceUrl)
    {
        $this->webserviceUrl = $webserviceUrl;
    }
    public function getServicePath()
    {
        return $this->servicePath;
    }
    public function setServicePath($servicePath)
    {
        $this->servicePath = $servicePath;
    }
    public function getResource($resource)
    {
        return $this->resources[$resource];
    }
    public function getCharset()
    {
        return $this->charset;
    }
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }
}

?>