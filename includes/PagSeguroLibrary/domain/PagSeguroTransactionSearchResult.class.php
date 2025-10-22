<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroTransactionSearchResult
{
    private $date = NULL;
    private $resultsInThisPage = NULL;
    private $totalPages = NULL;
    private $currentPage = NULL;
    private $transactions = NULL;
    public function getCurrentPage()
    {
        return $this->currentPage;
    }
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
    }
    public function getDate()
    {
        return $this->date;
    }
    public function setDate($date)
    {
        $this->date = $date;
    }
    public function getResultsInThisPage()
    {
        return $this->resultsInThisPage;
    }
    public function setResultsInThisPage($resultsInThisPage)
    {
        $this->resultsInThisPage = $resultsInThisPage;
    }
    public function getTotalPages()
    {
        return $this->totalPages;
    }
    public function setTotalPages($totalPages)
    {
        $this->totalPages = $totalPages;
    }
    public function getTransactions()
    {
        return $this->transactions;
    }
    public function setTransactions($transactions)
    {
        $this->transactions = $transactions;
    }
    public function toString()
    {
        $transaction = [];
        $transaction["Date"] = $this->date;
        $transaction["CurrentPage"] = $this->currentPage;
        $transaction["TotalPages"] = $this->totalPages;
        $transaction["Transactions in this page"] = $this->resultsInThisPage;
        return "PagSeguroTransactionSearchResult: " . var_export($transaction, true);
    }
}

?>