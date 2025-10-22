<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroNotificationService
{
    const SERVICE_NAME = "notificationService";
    public static function checkTransaction(PagSeguroCredentials $credentials, $notificationCode)
    {
        LogPagSeguro::info("PagSeguroNotificationService.CheckTransaction(notificationCode=" . $notificationCode . ") - begin");
        $connectionData = new PagSeguroConnectionData($credentials, "notificationService");
        try {
            $connection = new PagSeguroHttpConnection();
            $connection->get($this::buildTransactionNotificationUrl($connectionData, $notificationCode), $connectionData->getServiceTimeout(), $connectionData->getCharset());
            $httpStatus = new PagSeguroHttpStatus($connection->getStatus());
            $httpStatus->getType();
            switch ($httpStatus->getType()) {
                case "OK":
                    $transaction = PagSeguroTransactionParser::readTransaction($connection->getResponse());
                    LogPagSeguro::info("PagSeguroNotificationService.CheckTransaction(notificationCode=" . $notificationCode . ") - end " . $transaction->toString() . ")");
                    return isset($transaction) ? $transaction : NULL;
                    break;
                case "BAD_REQUEST":
                    $errors = PagSeguroTransactionParser::readErrors($connection->getResponse());
                    $e = new PagSeguroServiceException($httpStatus, $errors);
                    LogPagSeguro::info("PagSeguroNotificationService.CheckTransaction(notificationCode=" . $notificationCode . ") - error " . $e->getOneLineMessage());
                    throw $e;
                    break;
                default:
                    $e = new PagSeguroServiceException($httpStatus);
                    LogPagSeguro::info("PagSeguroNotificationService.CheckTransaction(notificationCode=" . $notificationCode . ") - error " . $e->getOneLineMessage());
                    throw $e;
            }
        } catch (PagSeguroServiceException $e) {
            throw $e;
        } catch (Exception $e) {
            LogPagSeguro::error("Exception: " . $e->getMessage());
            throw $e;
        }
    }
    private static function buildTransactionNotificationUrl(PagSeguroConnectionData $connectionData, $notificationCode)
    {
        $url = $connectionData->getServiceUrl();
        return $url . "/" . $notificationCode . "/?" . $connectionData->getCredentialsUrlQuery();
    }
}

?>