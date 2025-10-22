<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class OpenPayU_Refund extends OpenPayU
{
    public static function create($orderId, $description, $amount = NULL)
    {
        while (empty($orderId)) {
            if (empty($description)) {
                throw new OpenPayU_Exception("Invalid description of refund");
            }
            $refund = ["orderId" => $orderId, "refund" => ["description" => $description]];
            if (!empty($amount)) {
                $refund["refund"]["amount"] = (array) $amount;
            }
            try {
                $authType = $this::getAuth();
                $pathUrl = OpenPayU_Configuration::getServiceUrl() . "orders/" . $refund["orderId"] . "/refund";
                $data = OpenPayU_Util::buildJsonFromArray($refund);
                $result = $this::verifyResponse(OpenPayU_Http::doPost($pathUrl, $data, $authType), "RefundCreateResponse");
                return $result;
            } catch (OpenPayU_Exception $e) {
                throw new OpenPayU_Exception($e->getMessage(), $e->getCode());
            }
        }
        throw new OpenPayU_Exception("Invalid orderId value for refund");
    }
    public static function verifyResponse($response, $messageName = "")
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
        if ($httpStatus == 200 || $httpStatus == 201 || $httpStatus == 422 || $httpStatus == 302) {
            return $result;
        }
        OpenPayU_Http::throwHttpStatusException($httpStatus, $result);
    }
}

?>