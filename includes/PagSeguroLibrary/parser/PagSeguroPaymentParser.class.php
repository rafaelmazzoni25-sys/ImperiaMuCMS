<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroPaymentParser extends PagSeguroServiceParser
{
    public static function getData($payment)
    {
        $data = NULL;
        if ($payment->getReference() != NULL) {
            $data["reference"] = $payment->getReference();
        }
        if ($payment->getSender() != NULL) {
            if ($payment->getSender()->getName() != NULL) {
                $data["senderName"] = $payment->getSender()->getName();
            }
            if ($payment->getSender()->getEmail() != NULL) {
                $data["senderEmail"] = $payment->getSender()->getEmail();
            }
            if ($payment->getSender()->getPhone() != NULL) {
                if ($payment->getSender()->getPhone()->getAreaCode() != NULL) {
                    $data["senderAreaCode"] = $payment->getSender()->getPhone()->getAreaCode();
                }
                if ($payment->getSender()->getPhone()->getNumber() != NULL) {
                    $data["senderPhone"] = $payment->getSender()->getPhone()->getNumber();
                }
            }
            if ($payment->getSender()->getDocuments() != NULL) {
                $documents = $payment->getSender()->getDocuments();
                if (is_array($documents) && count($documents) == 1) {
                    foreach ($documents as $document) {
                        if (!is_null($document)) {
                            $data["senderCPF"] = $document->getValue();
                        }
                    }
                }
            }
        }
        if ($payment->getCurrency() != NULL) {
            $data["currency"] = $payment->getCurrency();
        }
        $items = $payment->getItems();
        if (0 < count($items)) {
            $i = 0;
            foreach ($items as $key => $value) {
                $i++;
                if ($items[$key]->getId() != NULL) {
                    $data["itemId" . $i] = $items[$key]->getId();
                }
                if ($items[$key]->getDescription() != NULL) {
                    $data["itemDescription" . $i] = $items[$key]->getDescription();
                }
                if ($items[$key]->getQuantity() != NULL) {
                    $data["itemQuantity" . $i] = $items[$key]->getQuantity();
                }
                if ($items[$key]->getAmount() != NULL) {
                    $amount = PagSeguroHelper::decimalFormat($items[$key]->getAmount());
                    $data["itemAmount" . $i] = $amount;
                }
                if ($items[$key]->getWeight() != NULL) {
                    $data["itemWeight" . $i] = $items[$key]->getWeight();
                }
                if ($items[$key]->getShippingCost() != NULL) {
                    $data["itemShippingCost" . $i] = PagSeguroHelper::decimalFormat($items[$key]->getShippingCost());
                }
            }
        }
        if ($payment->getExtraAmount() != NULL) {
            $data["extraAmount"] = PagSeguroHelper::decimalFormat($payment->getExtraAmount());
        }
        if ($payment->getShipping() != NULL) {
            if ($payment->getShipping()->getType() != NULL && $payment->getShipping()->getType()->getValue() != NULL) {
                $data["shippingType"] = $payment->getShipping()->getType()->getValue();
            }
            if ($payment->getShipping()->getCost() != NULL && $payment->getShipping()->getCost() != NULL) {
                $data["shippingCost"] = PagSeguroHelper::decimalFormat($payment->getShipping()->getCost());
            }
            if ($payment->getShipping()->getAddress() != NULL) {
                if ($payment->getShipping()->getAddress()->getStreet() != NULL) {
                    $data["shippingAddressStreet"] = $payment->getShipping()->getAddress()->getStreet();
                }
                if ($payment->getShipping()->getAddress()->getNumber() != NULL) {
                    $data["shippingAddressNumber"] = $payment->getShipping()->getAddress()->getNumber();
                }
                if ($payment->getShipping()->getAddress()->getComplement() != NULL) {
                    $data["shippingAddressComplement"] = $payment->getShipping()->getAddress()->getComplement();
                }
                if ($payment->getShipping()->getAddress()->getCity() != NULL) {
                    $data["shippingAddressCity"] = $payment->getShipping()->getAddress()->getCity();
                }
                if ($payment->getShipping()->getAddress()->getState() != NULL) {
                    $data["shippingAddressState"] = $payment->getShipping()->getAddress()->getState();
                }
                if ($payment->getShipping()->getAddress()->getDistrict() != NULL) {
                    $data["shippingAddressDistrict"] = $payment->getShipping()->getAddress()->getDistrict();
                }
                if ($payment->getShipping()->getAddress()->getPostalCode() != NULL) {
                    $data["shippingAddressPostalCode"] = $payment->getShipping()->getAddress()->getPostalCode();
                }
                if ($payment->getShipping()->getAddress()->getCountry() != NULL) {
                    $data["shippingAddressCountry"] = $payment->getShipping()->getAddress()->getCountry();
                }
            }
        }
        if ($payment->getMaxAge() != NULL) {
            $data["maxAge"] = $payment->getMaxAge();
        }
        if ($payment->getMaxUses() != NULL) {
            $data["maxUses"] = $payment->getMaxUses();
        }
        if ($payment->getRedirectURL() != NULL) {
            $data["redirectURL"] = $payment->getRedirectURL();
        }
        if ($payment->getNotificationURL() != NULL) {
            $data["notificationURL"] = $payment->getNotificationURL();
        }
        if (0 < count($payment->getMetaData()->getItems())) {
            $i = 0;
            foreach ($payment->getMetaData()->getItems() as $item) {
                if ($item instanceof PagSeguroMetaDataItem && !PagSeguroHelper::isEmpty($item->getKey()) && !PagSeguroHelper::isEmpty($item->getValue())) {
                    $i++;
                    $data["metadataItemKey" . $i] = $item->getKey();
                    $data["metadataItemValue" . $i] = $item->getValue();
                    if (!PagSeguroHelper::isEmpty($item->getGroup())) {
                        $data["metadataItemGroup" . $i] = $item->getGroup();
                    }
                }
            }
        }
        if (0 < count($payment->getParameter()->getItems())) {
            foreach ($payment->getParameter()->getItems() as $item) {
                if ($item instanceof PagSeguroParameterItem && !PagSeguroHelper::isEmpty($item->getKey()) && !PagSeguroHelper::isEmpty($item->getValue())) {
                    if (!PagSeguroHelper::isEmpty($item->getGroup())) {
                        $data[$item->getKey() . "" . $item->getGroup()] = $item->getValue();
                    } else {
                        $data[$item->getKey()] = $item->getValue();
                    }
                }
            }
        }
        return $data;
    }
    public static function readSuccessXml($str_xml)
    {
        $parser = new PagSeguroXmlParser($str_xml);
        $data = $parser->getResult("checkout");
        $PaymentParserData = new PagSeguroPaymentParserData();
        $PaymentParserData->setCode($data["code"]);
        $PaymentParserData->setRegistrationDate($data["date"]);
        return $PaymentParserData;
    }
}

?>