<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Paymentwall_Pingback extends Paymentwall_Instance
{
    protected $ipAddress = NULL;
    const PINGBACK_TYPE_REGULAR = 0;
    const PINGBACK_TYPE_GOODWILL = 1;
    const PINGBACK_TYPE_NEGATIVE = 2;
    const PINGBACK_TYPE_RISK_UNDER_REVIEW = 200;
    const PINGBACK_TYPE_RISK_REVIEWED_ACCEPTED = 201;
    const PINGBACK_TYPE_RISK_REVIEWED_DECLINED = 202;
    const PINGBACK_TYPE_RISK_AUTHORIZATION_VOIDED = 203;
    const PINGBACK_TYPE_SUBSCRIPTION_CANCELLATION = 12;
    const PINGBACK_TYPE_SUBSCRIPTION_EXPIRED = 13;
    const PINGBACK_TYPE_SUBSCRIPTION_PAYMENT_FAILED = 14;
    public function __construct($parameters, $ipAddress)
    {
        $this->parameters = $parameters;
        $this->ipAddress = $ipAddress;
    }
    public function validate($skipIpWhitelistCheck = false)
    {
        $validated = false;
        if ($this->isParametersValid()) {
            if ($this->isIpAddressValid() || $skipIpWhitelistCheck) {
                if ($this->isSignatureValid()) {
                    $validated = true;
                } else {
                    $this->appendToErrors("Wrong signature");
                }
            } else {
                $this->appendToErrors("IP address is not whitelisted");
            }
        } else {
            $this->appendToErrors("Missing parameters");
        }
        return $validated;
    }
    public function isSignatureValid()
    {
        $signatureParamsToSign = [];
        if ($this->getApiType() == Paymentwall_Config::API_VC) {
            $signatureParams = ["uid", "currency", "type", "ref"];
        } else {
            if ($this->getApiType() == Paymentwall_Config::API_GOODS) {
                $signatureParams = ["uid", "goodsid", "slength", "speriod", "type", "ref"];
            } else {
                $signatureParams = ["uid", "goodsid", "type", "ref"];
                $this->parameters["sign_version"] = Paymentwall_Signature_Abstract::VERSION_TWO;
            }
        }
        if (empty($this->parameters["sign_version"]) || $this->parameters["sign_version"] == Paymentwall_Signature_Abstract::VERSION_ONE) {
            foreach ($signatureParams as $field) {
                $signatureParamsToSign[$field] = isset($this->parameters[$field]) ? $this->parameters[$field] : NULL;
            }
            $this->parameters["sign_version"] = Paymentwall_Signature_Abstract::VERSION_ONE;
        } else {
            $signatureParamsToSign = $this->parameters;
        }
        $pingbackSignatureModel = new Paymentwall_Signature_Pingback();
        $signatureCalculated = $pingbackSignatureModel->calculate($signatureParamsToSign, $this->parameters["sign_version"]);
        $signature = isset($this->parameters["sig"]) ? $this->parameters["sig"] : NULL;
        return $signature == $signatureCalculated;
    }
    public function isIpAddressValid()
    {
        $ipsWhitelist = ["174.36.92.186", "174.36.96.66", "174.36.92.187", "174.36.92.192", "174.37.14.28"];
        return in_array($this->ipAddress, $ipsWhitelist);
    }
    public function isParametersValid()
    {
        $errorsNumber = 0;
        if ($this->getApiType() == Paymentwall_Config::API_VC) {
            $requiredParams = ["uid", "currency", "type", "ref", "sig"];
        } else {
            if ($this->getApiType() == Paymentwall_Config::API_GOODS) {
                $requiredParams = ["uid", "goodsid", "type", "ref", "sig"];
            } else {
                $requiredParams = ["uid", "goodsid", "type", "ref", "sig"];
            }
        }
        foreach ($requiredParams as $field) {
            if (!isset($this->parameters[$field]) || $this->parameters[$field] === "") {
                $this->appendToErrors("Parameter " . $field . " is missing");
                $errorsNumber++;
            }
        }
        return $errorsNumber == 0;
    }
    public function getParameter($param)
    {
        return isset($this->parameters[$param]) ? $this->parameters[$param] : NULL;
    }
    public function getType()
    {
        return isset($this->parameters["type"]) ? intval($this->parameters["type"]) : NULL;
    }
    public function getTypeVerbal()
    {
        $typeVerbal = "";
        $pingbackTypes = ["12" => "user_subscription_cancellation", "13" => "user_subscription_expired", "14" => "user_subscription_payment_failed"];
        if (!empty($this->parameters["type"]) && array_key_exists($this->parameters["type"], $pingbackTypes)) {
            $typeVerbal = $pingbackTypes[$this->parameters["type"]];
        }
        return $typeVerbal;
    }
    public function getUserId()
    {
        return $this->getParameter("uid");
    }
    public function getVirtualCurrencyAmount()
    {
        return $this->getParameter("currency");
    }
    public function getProductId()
    {
        return $this->getParameter("goodsid");
    }
    public function getProductPeriodLength()
    {
        return $this->getParameter("slength");
    }
    public function getProductPeriodType()
    {
        return $this->getParameter("speriod");
    }
    public function getProduct()
    {
        return new Paymentwall_Product($this->getProductId(), 0, NULL, NULL, 0 < $this->getProductPeriodLength() ? Paymentwall_Product::TYPE_SUBSCRIPTION : Paymentwall_Product::TYPE_FIXED, $this->getProductPeriodLength(), $this->getProductPeriodType());
    }
    public function getProducts()
    {
        $result = [];
        $productIds = $this->getParameter("goodsid");
        if (!empty($productIds) && is_array($productIds)) {
            foreach ($productIds as $Id) {
                $result[] = new Paymentwall_Product($Id);
            }
        }
        return $result;
    }
    public function getReferenceId()
    {
        return $this->getParameter("ref");
    }
    public function getPingbackUniqueId()
    {
        return $this->getReferenceId() . "_" . $this->getType();
    }
    public function isDeliverable()
    {
        return $this->getType() === 0 || $this->getType() === 1 || $this->getType() === 201;
    }
    public function isCancelable()
    {
        return $this->getType() === 2 || $this->getType() === 202;
    }
    public function isUnderReview()
    {
        return $this->getType() === 200;
    }
}

?>