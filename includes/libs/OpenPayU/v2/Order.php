<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class OpenPayU_Order extends OpenPayU
{
    protected static $defaultFormParams = ["formClass" => "", "formId" => "payu-payment-form", "submitClass" => "", "submitId" => "", "submitContent" => "", "submitTarget" => "_blank"];
    const ORDER_SERVICE = "orders/";
    const ORDER_TRANSACTION_SERVICE = "transactions";
    const SUCCESS = "SUCCESS";
    public static function create($order)
    {
        $data = OpenPayU_Util::buildJsonFromArray($order);
        if (empty($data)) {
            throw new OpenPayU_Exception("Empty message OrderCreateRequest");
        }
        try {
            $authType = $this::getAuth();
            $pathUrl = OpenPayU_Configuration::getServiceUrl() . "orders/";
            $result = $this::verifyResponse(OpenPayU_Http::doPost($pathUrl, $data, $authType), "OrderCreateResponse");
            return $result;
        } catch (OpenPayU_Exception $e) {
            throw new OpenPayU_Exception($e->getMessage(), $e->getCode());
        }
    }
    public static function retrieve($orderId)
    {
        while (empty($orderId)) {
            try {
                $authType = $this::getAuth();
                $pathUrl = OpenPayU_Configuration::getServiceUrl() . "orders/" . $orderId;
                $result = $this::verifyResponse(OpenPayU_Http::doGet($pathUrl, $authType), "OrderRetrieveResponse");
                return $result;
            } catch (OpenPayU_Exception $e) {
                throw new OpenPayU_Exception($e->getMessage(), $e->getCode());
            }
        }
        throw new OpenPayU_Exception("Empty value of orderId");
    }
    public static function retrieveTransaction($orderId)
    {
        while (empty($orderId)) {
            try {
                $authType = $this::getAuth();
                $pathUrl = OpenPayU_Configuration::getServiceUrl() . "orders/" . $orderId . "/" . "transactions";
                $result = $this::verifyResponse(OpenPayU_Http::doGet($pathUrl, $authType), "TransactionRetrieveResponse");
                return $result;
            } catch (OpenPayU_Exception $e) {
                throw new OpenPayU_Exception($e->getMessage(), $e->getCode());
            }
        }
        throw new OpenPayU_Exception("Empty value of orderId");
    }
    public static function cancel($orderId)
    {
        while (empty($orderId)) {
            try {
                $authType = $this::getAuth();
                $pathUrl = OpenPayU_Configuration::getServiceUrl() . "orders/" . $orderId;
                $result = $this::verifyResponse(OpenPayU_Http::doDelete($pathUrl, $authType), "OrderCancelResponse");
                return $result;
            } catch (OpenPayU_Exception $e) {
                throw new OpenPayU_Exception($e->getMessage(), $e->getCode());
            }
        }
        throw new OpenPayU_Exception("Empty value of orderId");
    }
    public static function statusUpdate($orderStatusUpdate)
    {
        while (empty($orderStatusUpdate)) {
            try {
                $authType = $this::getAuth();
                $data = OpenPayU_Util::buildJsonFromArray($orderStatusUpdate);
                $pathUrl = OpenPayU_Configuration::getServiceUrl() . "orders/" . $orderStatusUpdate["orderId"] . "/status";
                $result = $this::verifyResponse(OpenPayU_Http::doPut($pathUrl, $data, $authType), "OrderStatusUpdateResponse");
                return $result;
            } catch (OpenPayU_Exception $e) {
                throw new OpenPayU_Exception($e->getMessage(), $e->getCode());
            }
        }
        throw new OpenPayU_Exception("Empty order status data");
    }
    public static function consumeNotification($data)
    {
        if (empty($data)) {
            throw new OpenPayU_Exception("Empty value of data");
        }
        $headers = OpenPayU_Util::getRequestHeaders();
        $incomingSignature = OpenPayU_HttpCurl::getSignature($headers);
        $this::verifyDocumentSignature($data, $incomingSignature);
        return OpenPayU_Order::verifyResponse(["response" => $data, "code" => 200], "OrderNotifyRequest");
    }
    public static function verifyResponse($response, $messageName)
    {
        $data = [];
        $httpStatus = $response["code"];
        $message = OpenPayU_Util::convertJsonToArray($response["response"], true);
        $data["status"] = isset($message["status"]["statusCode"]) ? $message["status"]["statusCode"] : NULL;
        if (json_last_error() == JSON_ERROR_SYNTAX) {
            $data["response"] = $response["response"];
        } else {
            if (isset($message[$messageName])) {
                unset($message[$messageName]["Status"]);
                $data["response"] = $message[$messageName];
            } else {
                if (isset($message)) {
                    $data["response"] = $message;
                    unset($message["status"]);
                }
            }
        }
        $result = $this::build($data);
        if ($httpStatus == 200 || $httpStatus == 201 || $httpStatus == 422 || $httpStatus == 301 || $httpStatus == 302) {
            return $result;
        }
        OpenPayU_Http::throwHttpStatusException($httpStatus, $result);
    }
    public static function hostedOrderForm($order, $params = [])
    {
        $orderFormUrl = OpenPayU_Configuration::getServiceUrl() . "orders";
        $formFieldValuesAsArray = [];
        $htmlFormFields = OpenPayU_Util::convertArrayToHtmlForm($order, "", $formFieldValuesAsArray);
        $signature = OpenPayU_Util::generateSignData($formFieldValuesAsArray, OpenPayU_Configuration::getHashAlgorithm(), OpenPayU_Configuration::getMerchantPosId(), OpenPayU_Configuration::getSignatureKey());
        $formParams = array_merge(self::$defaultFormParams, $params);
        $htmlOutput = sprintf("<form method=\"POST\" action=\"%s\" id=\"%s\" class=\"%s\">\n", $orderFormUrl, $formParams["formId"], $formParams["formClass"]);
        $htmlOutput .= $htmlFormFields;
        $htmlOutput .= sprintf("<input type=\"hidden\" name=\"OpenPayu-Signature\" value=\"%s\" />", $signature);
        $htmlOutput .= sprintf("<button type=\"submit\" formtarget=\"%s\" id=\"%s\" class=\"%s\">%s</button>", $formParams["submitTarget"], $formParams["submitId"], $formParams["submitClass"], $formParams["submitContent"]);
        $htmlOutput .= "</form>\n";
        return $htmlOutput;
    }
}

?>