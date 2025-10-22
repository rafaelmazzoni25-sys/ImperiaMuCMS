<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroTransaction
{
    private $date = NULL;
    private $lastEventDate = NULL;
    private $code = NULL;
    private $reference = NULL;
    private $type = NULL;
    private $status = NULL;
    private $cancellationSource = NULL;
    private $paymentMethod = NULL;
    private $grossAmount = NULL;
    private $discountAmount = NULL;
    private $feeAmount = NULL;
    private $netAmount = NULL;
    private $extraAmount = NULL;
    private $installmentCount = NULL;
    private $items = NULL;
    private $sender = NULL;
    private $shipping = NULL;
    public function getLastEventDate()
    {
        return $this->lastEventDate;
    }
    public function setLastEventDate($lastEventDate)
    {
        $this->lastEventDate = $lastEventDate;
    }
    public function getDate()
    {
        return $this->date;
    }
    public function setDate($date)
    {
        $this->date = $date;
    }
    public function getCode()
    {
        return $this->code;
    }
    public function setCode($code)
    {
        $this->code = $code;
    }
    public function getReference()
    {
        return $this->reference;
    }
    public function setReference($reference)
    {
        $this->reference = $reference;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setType(PagSeguroTransactionType $type)
    {
        $this->type = $type;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus(PagSeguroTransactionStatus $status)
    {
        $this->status = $status;
    }
    public function getCancellationSource()
    {
        return $this->cancellationSource;
    }
    public function setCancellationSource(PagSeguroTransactionCancellationSource $cancellationSource)
    {
        $this->cancellationSource = $cancellationSource;
    }
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }
    public function setPaymentMethod(PagSeguroPaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }
    public function getGrossAmount()
    {
        return $this->grossAmount;
    }
    public function setGrossAmount($totalValue)
    {
        $this->grossAmount = $totalValue;
    }
    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }
    public function setDiscountAmount($discountAmount)
    {
        $this->discountAmount = $discountAmount;
    }
    public function getFeeAmount()
    {
        return $this->feeAmount;
    }
    public function setFeeAmount($feeAmount)
    {
        $this->feeAmount = $feeAmount;
    }
    public function getNetAmount()
    {
        return $this->netAmount;
    }
    public function setNetAmount($netAmount)
    {
        $this->netAmount = $netAmount;
    }
    public function getExtraAmount()
    {
        return $this->extraAmount;
    }
    public function setExtraAmount($extraAmount)
    {
        $this->extraAmount = $extraAmount;
    }
    public function getInstallmentCount()
    {
        return $this->installmentCount;
    }
    public function setInstallmentCount($installmentCount)
    {
        $this->installmentCount = $installmentCount;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setItems($items)
    {
        $this->items = $items;
    }
    public function getItemCount()
    {
        return $this->items == NULL ? NULL : count($this->items);
    }
    public function getSender()
    {
        return $this->sender;
    }
    public function setSender(PagSeguroSender $sender)
    {
        $this->sender = $sender;
    }
    public function getShipping()
    {
        return $this->shipping;
    }
    public function setShipping(PagSeguroShipping $shipping)
    {
        $this->shipping = $shipping;
    }
    public function toString()
    {
        $transaction = [];
        $transaction["code"] = $this->code;
        $transaction["email"] = $this->sender ? $this->sender->getEmail() : "null";
        $transaction["date"] = $this->date;
        $transaction["reference"] = $this->reference;
        $transaction["status"] = $this->status ? $this->status->getValue() : "null";
        $transaction["itemsCount"] = is_array($this->items) ? count($this->items) : "null";
        $transaction = "Transaction: " . var_export($transaction, true);
        return $transaction;
    }
}

?>