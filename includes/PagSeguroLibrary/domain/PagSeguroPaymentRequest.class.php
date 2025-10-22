<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroPaymentRequest
{
    private $sender = NULL;
    private $currency = NULL;
    private $items = NULL;
    private $redirectURL = NULL;
    private $extraAmount = NULL;
    private $reference = NULL;
    private $shipping = NULL;
    private $maxAge = NULL;
    private $maxUses = NULL;
    private $notificationURL = NULL;
    private $metadata = NULL;
    private $parameter = NULL;
    public function setSenderName($senderName)
    {
        if ($this->sender == NULL) {
            $this->sender = new PagSeguroSender();
        }
        $this->sender->setName($senderName);
    }
    public function setSenderEmail($senderEmail)
    {
        if ($this->sender == NULL) {
            $this->sender = new PagSeguroSender();
        }
        $this->sender->setEmail($senderEmail);
    }
    public function setSenderPhone($areaCode, $number = NULL)
    {
        $param = $areaCode;
        if ($this->sender == NULL) {
            $this->sender = new PagSeguroSender();
        }
        if ($param instanceof PagSeguroPhone) {
            $this->sender->setPhone($param);
        } else {
            $this->sender->setPhone(new PagSeguroPhone($param, $number));
        }
    }
    public function getCurrency()
    {
        return $this->currency;
    }
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setItems($items)
    {
        if (is_array($items)) {
            $i = [];
            foreach ($items as $key => $item) {
                if ($item instanceof PagSeguroItem) {
                    $i[$key] = $item;
                } else {
                    if (is_array($item)) {
                        $i[$key] = new PagSeguroItem($item);
                    }
                }
            }
            $this->items = $i;
        }
    }
    public function addItem($id, $description = NULL, $quantity = NULL, $amount = NULL, $weight = NULL, $shippingCost = NULL)
    {
        $param = $id;
        if ($this->items == NULL) {
            $this->items = [];
        }
        if (is_array($param)) {
            array_push($this->items, new PagSeguroItem($param));
        } else {
            if ($param instanceof PagSeguroItem) {
                array_push($this->items, $param);
            } else {
                $item = new PagSeguroItem();
                $item->setId($param);
                $item->setDescription($description);
                $item->setQuantity($quantity);
                $item->setAmount($amount);
                $item->setWeight($weight);
                $item->setShippingCost($shippingCost);
                array_push($this->items, $item);
            }
        }
    }
    public function addSenderDocument($type, $value)
    {
        if ($this->getSender() instanceof PagSeguroSender) {
            $this->getSender()->addDocument($type, $value);
        }
    }
    public function getSender()
    {
        return $this->sender;
    }
    public function setSender($name, $email = NULL, $areaCode = NULL, $number = NULL, $documentType = NULL, $documentValue = NULL)
    {
        $param = $name;
        if (is_array($param)) {
            $this->sender = new PagSeguroSender($param);
        } else {
            if ($param instanceof PagSeguroSender) {
                $this->sender = $param;
            } else {
                $sender = new PagSeguroSender();
                $sender->setName($param);
                $sender->setEmail($email);
                $sender->setPhone(new PagSeguroPhone($areaCode, $number));
                $sender->addDocument($documentType, $documentValue);
                $this->sender = $sender;
            }
        }
    }
    public function getRedirectURL()
    {
        return $this->redirectURL;
    }
    public function setRedirectURL($redirectURL)
    {
        $this->redirectURL = $this->verifyURLTest($redirectURL);
    }
    public function verifyURLTest($url)
    {
        $adress = ["localhost", "127.0.0.1", "::1"];
        foreach ($adress as $item) {
            $find = strpos($url, $item);
            if ($find) {
                $urlReturn = "";
                return $urlReturn;
            }
            $urlReturn = $url;
        }
    }
    public function getExtraAmount()
    {
        return $this->extraAmount;
    }
    public function setExtraAmount($extraAmount)
    {
        $this->extraAmount = $extraAmount;
    }
    public function getReference()
    {
        return $this->reference;
    }
    public function setReference($reference)
    {
        $this->reference = $reference;
    }
    public function getShipping()
    {
        return $this->shipping;
    }
    public function setShipping($address, $type = NULL)
    {
        $param = $address;
        if ($param instanceof PagSeguroShipping) {
            $this->shipping = $param;
        } else {
            $shipping = new PagSeguroShipping();
            if (is_array($param)) {
                $shipping->setAddress(new PagSeguroAddress($param));
            } else {
                if ($param instanceof PagSeguroAddress) {
                    $shipping->setAddress($param);
                }
            }
            if ($type) {
                if ($type instanceof PagSeguroShippingType) {
                    $shipping->setType($type);
                } else {
                    $shipping->setType(new PagSeguroShippingType($type));
                }
            }
            $this->shipping = $shipping;
        }
    }
    public function setShippingAddress($postalCode = NULL, $street = NULL, $number = NULL, $complement = NULL, $district = NULL, $city = NULL, $state = NULL, $country = NULL)
    {
        $param = $postalCode;
        if ($this->shipping == NULL) {
            $this->shipping = new PagSeguroShipping();
        }
        if (is_array($param)) {
            $this->shipping->setAddress(new PagSeguroAddress($param));
        } else {
            if ($param instanceof PagSeguroAddress) {
                $this->shipping->setAddress($param);
            } else {
                $address = new PagSeguroAddress();
                $address->setPostalCode($postalCode);
                $address->setStreet($street);
                $address->setNumber($number);
                $address->setComplement($complement);
                $address->setDistrict($district);
                $address->setCity($city);
                $address->setState($state);
                $address->setCountry($country);
                $this->shipping->setAddress($address);
            }
        }
    }
    public function setShippingType($type)
    {
        $param = $type;
        if ($this->shipping == NULL) {
            $this->shipping = new PagSeguroShipping();
        }
        if ($param instanceof PagSeguroShippingType) {
            $this->shipping->setType($param);
        } else {
            $this->shipping->setType(new PagSeguroShippingType($param));
        }
    }
    public function setShippingCost($shippingCost)
    {
        $param = $shippingCost;
        if ($this->shipping == NULL) {
            $this->shipping = new PagSeguroShipping();
        }
        $this->shipping->setCost($param);
    }
    public function getMaxAge()
    {
        return $this->maxAge;
    }
    public function setMaxAge($maxAge)
    {
        $this->maxAge = $maxAge;
    }
    public function getMaxUses()
    {
        return $this->maxUses;
    }
    public function setMaxUses($maxUses)
    {
        $this->maxUses = $maxUses;
    }
    public function getNotificationURL()
    {
        return $this->notificationURL;
    }
    public function setNotificationURL($notificationURL)
    {
        $this->notificationURL = $this->verifyURLTest($notificationURL);
    }
    public function addMetaData($itemKey, $itemValue, $itemGroup = NULL)
    {
        $this->getMetaData()->addItem(new PagSeguroMetaDataItem($itemKey, $itemValue, $itemGroup));
    }
    public function getMetaData()
    {
        if ($this->metadata == NULL) {
            $this->metadata = new PagSeguroMetaData();
        }
        return $this->metadata;
    }
    public function setMetaData($metaData)
    {
        $this->metadata = $metaData;
    }
    public function addParameter($parameterName, $parameterValue)
    {
        $this->getParameter()->addItem(new PagSeguroParameterItem($parameterName, $parameterValue));
    }
    public function getParameter()
    {
        if ($this->parameter == NULL) {
            $this->parameter = new PagSeguroParameter();
        }
        return $this->parameter;
    }
    public function setParameter($parameter)
    {
        $this->parameter = $parameter;
    }
    public function addIndexedParameter($parameterName, $parameterValue, $parameterIndex)
    {
        $this->getParameter()->addItem(new PagSeguroParameterItem($parameterName, $parameterValue, $parameterIndex));
    }
    public function register(PagSeguroCredentials $credentials, $onlyCheckoutCode = false)
    {
        return PagSeguroPaymentService::createCheckoutRequest($credentials, $this, $onlyCheckoutCode);
    }
    public function toString()
    {
        $email = $this->sender ? $this->sender->getEmail() : "null";
        $request = [];
        $request["Reference"] = $this->reference;
        $request["SenderEmail"] = $email;
        return "PagSeguroPaymentRequest: " . var_export($request, true);
    }
}

?>