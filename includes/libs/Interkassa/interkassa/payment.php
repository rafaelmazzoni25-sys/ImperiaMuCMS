<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Interkassa_Payment
{
    protected $_currency = NULL;
    public static function factory(Interkassa_Shop $shop, $options)
    {
        return new Interkassa_Payment($shop, $options);
    }
    public function __construct(Interkassa_Shop $shop, $options)
    {
        $this->_shop = $shop;
        if (!isset($options["id"])) {
            throw new Interkassa_Exception("Payment id is required");
        }
        if (!isset($options["amount"])) {
            throw new Interkassa_Exception("Payment amount is required");
        }
        if (!isset($options["description"])) {
            throw new Interkassa_Exception("Payment description is required");
        }
        $this->_id = (string) $options["id"];
        $this->_amount = (object) $options["amount"];
        $this->_description = (string) $options["description"];
        if (!empty($options["baggage"])) {
            $this->setBaggage($options["baggage"]);
        }
        if (!empty($options["success_url"])) {
            $this->setSuccessUrl($options["success_url"]);
        }
        if (!empty($options["success_method"])) {
            $this->setSuccessMethod($options["success_method"]);
        }
        if (!empty($options["fail_url"])) {
            $this->setFailUrl($options["fail_url"]);
        }
        if (!empty($options["fail_method"])) {
            $this->setFailMethod($options["fail_method"]);
        }
        if (!empty($options["status_url"])) {
            $this->setStatusUrl($options["status_url"]);
        }
        if (!empty($options["status_method"])) {
            $this->setStatusMethod($options["status_method"]);
        }
        if (!empty($options["form_action"])) {
            $this->setFormAction($options["form_action"]);
        }
        if (!empty($options["locale"])) {
            $this->setLocale($options["locale"]);
        }
        if (!empty($options["currency"])) {
            $this->setCurrency($options["currency"]);
        }
    }
    public function getId()
    {
        return $this->_id;
    }
    public function getAmount()
    {
        return $this->_amount;
    }
    public function getAmountAsString($decimals = 2)
    {
        return number_format($this->_amount, $decimals, ".", "");
    }
    public function getDescription()
    {
        return $this->_description;
    }
    public function getBaggage()
    {
        return $this->_baggage;
    }
    public function setBaggage($baggage)
    {
        if (!empty($baggage)) {
            $this->_baggage = (string) $baggage;
        }
        return $this;
    }
    public function getSuccessUrl()
    {
        return $this->_success_url;
    }
    public function setSuccessUrl($url)
    {
        if (!empty($url)) {
            $this->_success_url = (string) $url;
        }
        return $this;
    }
    public function getSuccessMethod()
    {
        return $this->_success_method;
    }
    public function setSuccessMethod($method)
    {
        if (empty($method)) {
            return $this;
        }
        $methods = [Interkassa::METHOD_POST, Interkassa::METHOD_GET, Interkassa::METHOD_LINK];
        if (in_array($method, $methods)) {
            $this->_success_method = $method;
        }
        return $this;
    }
    public function getFailUrl()
    {
        return $this->_fail_url;
    }
    public function setFailUrl($url)
    {
        if (!empty($url)) {
            $this->_fail_url = (string) $url;
        }
        return $this;
    }
    public function getFailMethod()
    {
        return $this->_fail_method;
    }
    public function setFailMethod($method)
    {
        if (empty($method)) {
            return $this;
        }
        $methods = [Interkassa::METHOD_POST, Interkassa::METHOD_GET, Interkassa::METHOD_LINK];
        if (in_array($method, $methods)) {
            $this->_fail_method = $method;
        }
        return $this;
    }
    public function getStatusUrl()
    {
        return $this->_status_url;
    }
    public function setStatusUrl($url)
    {
        if (!empty($url)) {
            $this->_status_url = (string) $url;
        }
        return $this;
    }
    public function getStatusMethod()
    {
        return $this->_status_method;
    }
    public function setStatusMethod($method)
    {
        if (empty($method)) {
            return $this;
        }
        $methods = [Interkassa::METHOD_POST, Interkassa::METHOD_GET, Interkassa::METHOD_OFF];
        if (in_array($method, $methods)) {
            $this->_status_method = $method;
        }
        return $this;
    }
    public function getFormValues()
    {
        $fields = ["ik_co_id" => $this->getShop()->getId(), "ik_am" => $this->getAmountAsString(), "ik_pm_no" => $this->getId(), "ik_desc" => $this->getDescription()];
        $success_url = $this->getSuccessUrl();
        $fail_url = $this->getFailUrl();
        $status_url = $this->getStatusUrl();
        $locale = $this->getLocale();
        $curr = $this->getCurrency();
        if ($locale) {
            $fields["ik_loc"] = $locale;
        }
        $fields["ik_x_baggage"] = (string) $this->getBaggage();
        if ($success_url) {
            $fields["ik_suc_u"] = (string) $success_url;
            $fields["ik_suc_m"] = (string) $this->getSuccessMethod();
        }
        if ($fail_url) {
            $fields["ik_fal_u"] = (string) $fail_url;
            $fields["ik_fal_m"] = (string) $this->getFailMethod();
        }
        if ($status_url) {
            $fields["ik_ia_u"] = (string) $status_url;
            $fields["ik_ia_m"] = (string) $this->getStatusMethod();
        }
        if ($curr) {
            $fields["ik_cur"] = (string) $curr;
        }
        return $fields;
    }
    public function getFormAction()
    {
        return $this->_form_action;
    }
    public function setFormAction($url)
    {
        if ($url) {
            $this->_form_action = (string) $url;
        }
        return $this;
    }
    public function getShop()
    {
        return $this->_shop;
    }
    public function setLocale($locale)
    {
        $this->_locale = $locale;
        return $this;
    }
    public function getLocale()
    {
        return $this->_locale;
    }
    public function setCurrency($currency)
    {
        $this->_currency = $currency;
        return $this;
    }
    public function getCurrency()
    {
        return $this->_currency;
    }
}

?>