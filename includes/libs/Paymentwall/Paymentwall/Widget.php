<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Paymentwall_Widget extends Paymentwall_Instance
{
    protected $extraParams = NULL;
    const CONTROLLER_PAYMENT_VIRTUAL_CURRENCY = "ps";
    const CONTROLLER_PAYMENT_DIGITAL_GOODS = "subscription";
    const CONTROLLER_PAYMENT_CART = "cart";
    public function __construct($userId, $widgetCode = "", $products = [], $extraParams = [])
    {
        $this->userId = $userId;
        $this->widgetCode = $widgetCode;
        $this->products = $products;
        $this->extraParams = $extraParams;
    }
    public function getUrl()
    {
        $params = ["key" => $this->getPublicKey(), "uid" => $this->userId, "widget" => $this->widgetCode];
        $productsNumber = count($this->products);
        if ($this->getApiType() == Paymentwall_Config::API_GOODS) {
            if (!empty($this->products) && $productsNumber == 1) {
                $product = current($this->products);
                if ($product->getTrialProduct() instanceof Paymentwall_Product) {
                    $postTrialProduct = $product;
                    $product = $product->getTrialProduct();
                }
                $params["amount"] = $product->getAmount();
                $params["currencyCode"] = $product->getCurrencyCode();
                $params["ag_name"] = $product->getName();
                $params["ag_external_id"] = $product->getId();
                $params["ag_type"] = $product->getType();
                if ($product->getType() == Paymentwall_Product::TYPE_SUBSCRIPTION) {
                    $params["ag_period_length"] = $product->getPeriodLength();
                    $params["ag_period_type"] = $product->getPeriodType();
                    if ($product->isRecurring()) {
                        $params["ag_recurring"] = intval($product->isRecurring());
                        if (isset($postTrialProduct)) {
                            $params["ag_trial"] = 1;
                            $params["ag_post_trial_external_id"] = $postTrialProduct->getId();
                            $params["ag_post_trial_period_length"] = $postTrialProduct->getPeriodLength();
                            $params["ag_post_trial_period_type"] = $postTrialProduct->getPeriodType();
                            $params["ag_post_trial_name"] = $postTrialProduct->getName();
                            $params["post_trial_amount"] = $postTrialProduct->getAmount();
                            $params["post_trial_currencyCode"] = $postTrialProduct->getCurrencyCode();
                        }
                    }
                }
            }
        } else {
            if ($this->getApiType() == Paymentwall_Config::API_CART) {
                $index = 0;
                foreach ($this->products as $product) {
                    $params["external_ids[" . $index . "]"] = $product->getId();
                    if (isset($product->amount)) {
                        $params["prices[" . $index . "]"] = $product->getAmount();
                    }
                    if (isset($product->currencyCode)) {
                        $params["currencies[" . $index . "]"] = $product->getCurrencyCode();
                    }
                    if (isset($product->name)) {
                        $params["names[" . $index . "]"] = $product->getName();
                    }
                    $index++;
                }
                unset($index);
            }
        }
        $params["sign_version"] = $signatureVersion = $this->getDefaultSignatureVersion();
        if (!empty($this->extraParams["sign_version"])) {
            $params["sign_version"] = $this->extraParams["sign_version"];
            $signatureVersion = $params["sign_version"];
        }
        $params = array_merge($params, $this->extraParams);
        $widgetSignatureModel = new Paymentwall_Signature_Widget();
        $params["sign"] = $widgetSignatureModel->calculate($params, $signatureVersion);
        return $this->getApiBaseUrl() . "/" . $this->buildController($this->widgetCode) . "?" . http_build_query($params);
    }
    public function getHtmlCode($attributes = [])
    {
        $defaultAttributes = ["frameborder" => "0", "width" => "750", "height" => "800"];
        $attributes = array_merge($defaultAttributes, $attributes);
        $attributesQuery = "";
        foreach ($attributes as $attr => $value) {
            $attributesQuery .= " " . $attr . "=\"" . $value . "\"";
        }
        return "<iframe src=\"" . $this->getUrl() . "\" " . $attributesQuery . "></iframe>";
    }
    protected function getDefaultSignatureVersion()
    {
        return $this->getApiType() != Paymentwall_Config::API_CART ? Paymentwall_Signature_Abstract::DEFAULT_VERSION : Paymentwall_Signature_Abstract::VERSION_TWO;
    }
    protected function buildController($widget = "")
    {
        $controller = NULL;
        $isPaymentWidget = !preg_match("/^w|s|mw/", $widget);
        if ($this->getApiType() == Paymentwall_Config::API_VC) {
            if ($isPaymentWidget) {
                $controller = "ps";
            }
        } else {
            if ($this->getApiType() == Paymentwall_Config::API_GOODS) {
                $controller = "subscription";
            } else {
                $controller = "cart";
            }
        }
        return $controller;
    }
}

?>