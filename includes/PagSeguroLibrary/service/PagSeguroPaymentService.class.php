<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroPaymentService
{
    const SERVICE_NAME = "paymentService";
    public static function createCheckoutRequest(PagSeguroCredentials $credentials, PagSeguroPaymentRequest $paymentRequest, $onlyCheckoutCode)
    {
        LogPagSeguro::info("PagSeguroPaymentService.Register(" . $paymentRequest->toString() . ") - begin");
        $connectionData = new PagSeguroConnectionData($credentials, "paymentService");
        try {
            $connection = new PagSeguroHttpConnection();
            $connection->post($this::buildCheckoutRequestUrl($connectionData), PagSeguroPaymentParser::getData($paymentRequest), $connectionData->getServiceTimeout(), $connectionData->getCharset());
            $httpStatus = new PagSeguroHttpStatus($connection->getStatus());
            $httpStatus->getType();
            switch ($httpStatus->getType()) {
                case "OK":
                    $PaymentParserData = PagSeguroPaymentParser::readSuccessXml($connection->getResponse());
                    if ($onlyCheckoutCode) {
                        $paymentReturn = $PaymentParserData->getCode();
                    } else {
                        $paymentReturn = $this::buildCheckoutUrl($connectionData, $PaymentParserData->getCode());
                    }
                    LogPagSeguro::info("PagSeguroPaymentService.Register(" . $paymentRequest->toString() . ") - end {1}" . $PaymentParserData->getCode());
                    return isset($paymentReturn) ? $paymentReturn : false;
                    break;
                case "BAD_REQUEST":
                    $errors = PagSeguroPaymentParser::readErrors($connection->getResponse());
                    $e = new PagSeguroServiceException($httpStatus, $errors);
                    LogPagSeguro::error("PagSeguroPaymentService.Register(" . $paymentRequest->toString() . ") - error " . $e->getOneLineMessage());
                    throw $e;
                    break;
                default:
                    $e = new PagSeguroServiceException($httpStatus);
                    LogPagSeguro::error("PagSeguroPaymentService.Register(" . $paymentRequest->toString() . ") - error " . $e->getOneLineMessage());
                    throw $e;
            }
        } catch (PagSeguroServiceException $e) {
            throw $e;
        } catch (Exception $e) {
            LogPagSeguro::error("Exception: " . $e->getMessage());
            throw $e;
        }
    }
    private static function buildCheckoutRequestUrl(PagSeguroConnectionData $connectionData)
    {
        return $connectionData->getServiceUrl() . "/?" . $connectionData->getCredentialsUrlQuery();
    }
    private static function buildCheckoutUrl(PagSeguroConnectionData $connectionData, $code)
    {
        return $connectionData->getPaymentUrl() . $connectionData->getResource("checkoutUrl") . "?code=" . $code;
    }
}

?>