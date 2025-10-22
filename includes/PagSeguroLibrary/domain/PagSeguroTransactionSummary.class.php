<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroTransactionSummary
{
    private $date = NULL;
    private $lastEventDate = NULL;
    private $code = NULL;
    private $reference = NULL;
    private $grossAmount = NULL;
    private $type = NULL;
    private $status = NULL;
    private $netAmount = NULL;
    private $discountAmount = NULL;
    private $feeAmount = NULL;
    private $extraAmount = NULL;
    private $cancellationSource = NULL;
    private $paymentMethod = NULL;
    private $recoveryCode = NULL;
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
    public function getGrossAmount()
    {
        return $this->grossAmount;
    }
    public function setGrossAmount($grossAmount)
    {
        $this->grossAmount = $grossAmount;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setType(PagSeguroTransactionType $type)
    {
        $this->type = $type;
    }
    public function getLastEventDate()
    {
        return $this->lastEventDate;
    }
    public function setLastEventDate($lastEventDate)
    {
        $this->lastEventDate = $lastEventDate;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus(PagSeguroTransactionStatus $status)
    {
        $this->status = $status;
    }
    public function getNetAmount()
    {
        return $this->netAmount;
    }
    public function setNetAmount($netAmount)
    {
        $this->netAmount = $netAmount;
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
    public function getExtraAmount()
    {
        return $this->extraAmount;
    }
    public function setExtraAmount($extraAmount)
    {
        $this->extraAmount = $extraAmount;
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
    public function getRecoveryCode()
    {
        return $this->recoveryCode;
    }
    public function setRecoveryCode($recoverycode)
    {
        $this->recoveryCode = $recoverycode;
    }
}

?>