<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroTransactionSearchService
{
    const SERVICE_NAME = "transactionSearchService";
    public static function searchByCode(PagSeguroCredentials $credentials, $transactionCode)
    {
        LogPagSeguro::info("PagSeguroTransactionSearchService.SearchByCode(" . $transactionCode . ") - begin");
        $connectionData = new PagSeguroConnectionData($credentials, "transactionSearchService");
        try {
            $connection = new PagSeguroHttpConnection();
            $connection->get($this::buildSearchUrlByCode($connectionData, $transactionCode), $connectionData->getServiceTimeout(), $connectionData->getCharset());
            $httpStatus = new PagSeguroHttpStatus($connection->getStatus());
            $httpStatus->getType();
            switch ($httpStatus->getType()) {
                case "OK":
                    $transaction = PagSeguroTransactionParser::readTransaction($connection->getResponse());
                    LogPagSeguro::info("PagSeguroTransactionSearchService.SearchByCode(transactionCode=" . $transactionCode . ") - end " . $transaction->toString());
                    return isset($transaction) ? $transaction : false;
                    break;
                case "BAD_REQUEST":
                    $errors = PagSeguroTransactionParser::readErrors($connection->getResponse());
                    $e = new PagSeguroServiceException($httpStatus, $errors);
                    LogPagSeguro::error("PagSeguroTransactionSearchService.SearchByCode(transactionCode=" . $transactionCode . ") - error " . $e->getOneLineMessage());
                    throw $e;
                    break;
                default:
                    $e = new PagSeguroServiceException($httpStatus);
                    LogPagSeguro::error("PagSeguroTransactionSearchService.SearchByCode(transactionCode=" . $transactionCode . ") - error " . $e->getOneLineMessage());
                    throw $e;
            }
        } catch (PagSeguroServiceException $e) {
            throw $e;
        } catch (Exception $e) {
            LogPagSeguro::error("Exception: " . $e->getMessage());
            throw $e;
        }
    }
    private static function buildSearchUrlByCode(PagSeguroConnectionData $connectionData, $transactionCode)
    {
        $url = $connectionData->getServiceUrl();
        return $url . "/" . $transactionCode . "/?" . $connectionData->getCredentialsUrlQuery();
    }
    public static function searchByDate(PagSeguroCredentials $credentials, $pageNumber, $maxPageResults, $initialDate, $finalDate = NULL)
    {
        LogPagSeguro::info("PagSeguroTransactionSearchService.SearchByDate(initialDate=" . PagSeguroHelper::formatDate($initialDate) . ", finalDate=" . PagSeguroHelper::formatDate($finalDate) . ") - begin");
        $connectionData = new PagSeguroConnectionData($credentials, "transactionSearchService");
        $searchParams = ["initialDate" => PagSeguroHelper::formatDate($initialDate), "pageNumber" => $pageNumber, "maxPageResults" => $maxPageResults];
        $searchParams["finalDate"] = $finalDate ? PagSeguroHelper::formatDate($finalDate) : NULL;
        try {
            $connection = new PagSeguroHttpConnection();
            $connection->get($this::buildSearchUrlByDate($connectionData, $searchParams), $connectionData->getServiceTimeout(), $connectionData->getCharset());
            $httpStatus = new PagSeguroHttpStatus($connection->getStatus());
            $httpStatus->getType();
            switch ($httpStatus->getType()) {
                case "OK":
                    $searchResult = PagSeguroTransactionParser::readSearchResult($connection->getResponse());
                    LogPagSeguro::info("PagSeguroTransactionSearchService.SearchByDate(initialDate=" . PagSeguroHelper::formatDate($initialDate) . ", finalDate=" . PagSeguroHelper::formatDate($finalDate) . ") - end " . $searchResult->toString());
                    return isset($searchResult) ? $searchResult : false;
                    break;
                case "BAD_REQUEST":
                    $errors = PagSeguroTransactionParser::readErrors($connection->getResponse());
                    $e = new PagSeguroServiceException($httpStatus, $errors);
                    LogPagSeguro::error("PagSeguroTransactionSearchService.SearchByDate(initialDate=" . PagSeguroHelper::formatDate($initialDate) . ", finalDate=" . PagSeguroHelper::formatDate($finalDate) . ") - end " . $e->getOneLineMessage());
                    throw $e;
                    break;
                default:
                    $e = new PagSeguroServiceException($httpStatus);
                    LogPagSeguro::error("PagSeguroTransactionSearchService.SearchByDate(initialDate=" . PagSeguroHelper::formatDate($initialDate) . ", finalDate=" . PagSeguroHelper::formatDate($finalDate) . ") - end " . $e->getOneLineMessage());
                    throw $e;
            }
        } catch (PagSeguroServiceException $e) {
            throw $e;
        } catch (Exception $e) {
            LogPagSeguro::error("Exception: " . $e->getMessage());
            throw $e;
        }
    }
    private static function buildSearchUrlByDate(PagSeguroConnectionData $connectionData, $searchParams)
    {
        $url = $connectionData->getServiceUrl();
        $initialDate = $searchParams["initialDate"] != NULL ? $searchParams["initialDate"] : "";
        $finalDate = $searchParams["finalDate"] != NULL ? "&finalDate=" . $searchParams["finalDate"] : "";
        if ($searchParams["pageNumber"] != NULL) {
            $page = "&page=" . $searchParams["pageNumber"];
        }
        if ($searchParams["maxPageResults"] != NULL) {
            $maxPageResults = "&maxPageResults=" . $searchParams["maxPageResults"];
        }
        return $url . "/?" . $connectionData->getCredentialsUrlQuery() . "&initialDate=" . $initialDate . $finalDate . $page . $maxPageResults;
    }
    public static function searchAbandoned(PagSeguroCredentials $credentials, $pageNumber, $maxPageResults, $initialDate, $finalDate = NULL)
    {
        LogPagSeguro::info("PagSeguroTransactionSearchService.searchAbandoned(initialDate=" . PagSeguroHelper::formatDate($initialDate) . ", finalDate=" . PagSeguroHelper::formatDate($finalDate) . ") - begin");
        $connectionData = new PagSeguroConnectionData($credentials, "transactionSearchService");
        $searchParams = ["initialDate" => PagSeguroHelper::formatDate($initialDate), "pageNumber" => $pageNumber, "maxPageResults" => $maxPageResults];
        $searchParams["finalDate"] = $finalDate ? PagSeguroHelper::formatDate($finalDate) : NULL;
        try {
            $connection = new PagSeguroHttpConnection();
            $connection->get($this::buildSearchUrlAbandoned($connectionData, $searchParams), $connectionData->getServiceTimeout(), $connectionData->getCharset());
            $httpStatus = new PagSeguroHttpStatus($connection->getStatus());
            $httpStatus->getType();
            switch ($httpStatus->getType()) {
                case "OK":
                    $searchResult = PagSeguroTransactionParser::readSearchResult($connection->getResponse());
                    LogPagSeguro::info("PagSeguroTransactionSearchService.searchAbandoned(initialDate=" . PagSeguroHelper::formatDate($initialDate) . ", finalDate=" . PagSeguroHelper::formatDate($finalDate) . ") - end " . $searchResult->toString());
                    return isset($searchResult) ? $searchResult : false;
                    break;
                case "BAD_REQUEST":
                    $errors = PagSeguroTransactionParser::readErrors($connection->getResponse());
                    $e = new PagSeguroServiceException($httpStatus, $errors);
                    LogPagSeguro::error("PagSeguroTransactionSearchService.searchAbandoned(initialDate=" . PagSeguroHelper::formatDate($initialDate) . ", finalDate=" . PagSeguroHelper::formatDate($finalDate) . ") - end " . $e->getOneLineMessage());
                    throw $e;
                    break;
                default:
                    $e = new PagSeguroServiceException($httpStatus);
                    LogPagSeguro::error("PagSeguroTransactionSearchService.searchAbandoned(initialDate=" . PagSeguroHelper::formatDate($initialDate) . ", finalDate=" . PagSeguroHelper::formatDate($finalDate) . ") - end " . $e->getOneLineMessage());
                    throw $e;
            }
        } catch (PagSeguroServiceException $e) {
            throw $e;
        } catch (Exception $e) {
            LogPagSeguro::error("Exception: " . $e->getMessage());
            throw $e;
        }
    }
    private static function buildSearchUrlAbandoned(PagSeguroConnectionData $connectionData, $searchParams)
    {
        $url = $connectionData->getServiceUrl();
        $initialDate = $searchParams["initialDate"] != NULL ? $searchParams["initialDate"] : "";
        $finalDate = $searchParams["finalDate"] != NULL ? "&finalDate=" . $searchParams["finalDate"] : "";
        if ($searchParams["pageNumber"] != NULL) {
            $page = "&page=" . $searchParams["pageNumber"];
        }
        if ($searchParams["maxPageResults"] != NULL) {
            $maxPageResults = "&maxPageResults=" . $searchParams["maxPageResults"];
        }
        return $url . "/abandoned/?" . $connectionData->getCredentialsUrlQuery() . "&initialDate=" . $initialDate . "&finalDate=" . $finalDate . $page . $maxPageResults;
    }
}

?>