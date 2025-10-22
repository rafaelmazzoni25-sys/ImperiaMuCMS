<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Interkassa_Status
{
    protected $_payment = false;
    public static function factory(Interkassa_Shop $shop, $source)
    {
        return new Interkassa_Status($shop, $source);
    }
    public function __construct(Interkassa_Shop $shop, $source)
    {
        $this->_shop = $shop;
        foreach (["ik_co_id" => "Shop id", "ik_pm_no" => "Payment id", "ik_am" => "Payment amount", "ik_desc" => "Payment description", "ik_pw_via" => "Payway Via", "ik_sign" => "Payment Signature", "ik_cur" => "Currency", "ik_inv_prc" => "Payment Time", "ik_inv_st" => "Payment State", "ik_trn_id" => "Transaction", "ik_ps_price" => "PaySystem Price", "ik_co_rfn" => "Checkout Refund"] as $field => $title) {
            if (!isset($source[$field])) {
                throw new Interkassa_Exception($title . " not received");
            }
        }
        $received_id = strtoupper($source["ik_co_id"]);
        $shop_id = strtoupper($shop->getId());
        if ($received_id !== $shop_id) {
            throw new Interkassa_Exception("Received shop id does not match current shop id");
        }
        if ($this->_checkSignature($source)) {
            $this->_verified = true;
            $payment = $shop->createPayment(["id" => $source["ik_pm_no"], "amount" => $source["ik_am"], "description" => $source["ik_desc"]]);
            if (!empty($source["ik_x_baggage"])) {
                $payment->setBaggage($source["ik_x_baggage"]);
            }
            $this->_payment = $payment;
            $this->_timestamp = $source["ik_inv_prc"];
            $this->_state = (string) $source["ik_inv_st"];
            $this->_trans_id = (string) $source["ik_trn_id"];
            $this->_currency = $source["ik_cur"];
            $this->_fees_payer = $source["ik_ps_price"] - $source["ik_co_rfn"];
        } else {
            throw new Interkassa_Exception("Signature does not match the data");
        }
    }
    public function getTimestamp()
    {
        return $this->_timestamp;
    }
    public function getDateTime()
    {
        return new DateTime("@" . $this->getTimestamp());
    }
    public function getState()
    {
        return $this->_state;
    }
    public function getTransId()
    {
        return $this->_trans_id;
    }
    public function getCurrencyName()
    {
        return $this->_currency;
    }
    public function getFeesPayer()
    {
        return $this->_fees_payer;
    }
    public function getVerified()
    {
        return $this->_verified;
    }
    public function getPayment()
    {
        return $this->_payment;
    }
    public function getShop()
    {
        return $this->_shop;
    }
    protected final function _checkSignature($source)
    {
        $post = $source;
        unset($post["ik_sign"]);
        ksort($post, SORT_STRING);
        array_push($post, $this->getShop()->getSecretKey());
        $signature = base64_encode(md5(implode(":", $post), true));
        return $source["ik_sign"] === $signature;
    }
}

?>