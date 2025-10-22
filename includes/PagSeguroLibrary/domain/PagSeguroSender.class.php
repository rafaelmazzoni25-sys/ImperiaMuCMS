<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroSender
{
    private $name = NULL;
    private $email = NULL;
    private $phone = NULL;
    private $documents = NULL;
    public function __construct($data = NULL)
    {
        if ($data) {
            if (isset($data["name"])) {
                $this->name = $data["name"];
            }
            if (isset($data["email"])) {
                $this->email = $data["email"];
            }
            if (isset($data["phone"]) && $data["phone"] instanceof PagSeguroPhone) {
                $this->phone = $data["phone"];
            } else {
                if (isset($data["areaCode"]) && isset($data["number"])) {
                    $phone = new PagSeguroPhone($data["areaCode"], $data["number"]);
                    $this->phone = $phone;
                }
            }
            if (isset($data["documents"]) && is_array($data["documents"])) {
                $this->setDocuments($data["documents"]);
            }
        }
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = PagSeguroHelper::formatString($name, 50, "");
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getPhone()
    {
        return $this->phone;
    }
    public function setPhone($areaCode, $number = NULL)
    {
        $param = $areaCode;
        if ($param instanceof PagSeguroPhone) {
            $this->phone = $param;
        } else {
            if ($number) {
                $phone = new PagSeguroPhone();
                $phone->setAreaCode($areaCode);
                $phone->setNumber($number);
                $this->phone = $phone;
            }
        }
    }
    public function getDocuments()
    {
        return $this->documents;
    }
    public function setDocuments($documents)
    {
        if (0 < count($documents)) {
            foreach ($documents as $document) {
                if ($document instanceof PagSeguroSenderDocument) {
                    $this->documents[] = $document;
                } else {
                    if (is_array($document)) {
                        $this->addDocument($document["type"], $document["value"]);
                    }
                }
            }
        }
    }
    public function addDocument($type, $value)
    {
        if ($type && $value && count($this->documents) == 0) {
            $document = new PagSeguroSenderDocument($type, $value);
            $this->documents[] = $document;
        }
    }
}

?>