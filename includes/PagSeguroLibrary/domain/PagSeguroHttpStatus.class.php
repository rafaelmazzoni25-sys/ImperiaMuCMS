<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroHttpStatus
{
    private $typeList = ["200" => "OK", "400" => "BAD_REQUEST", "401" => "UNAUTHORIZED", "403" => "FORBIDDEN", "404" => "NOT_FOUND", "500" => "INTERNAL_SERVER_ERROR", "502" => "BAD_GATEWAY"];
    private $status = NULL;
    private $type = NULL;
    public function __construct($status)
    {
        if ($status) {
            $this->status = (array) $status;
            $this->type = $this->getTypeByStatus($this->status);
        }
    }
    private function getTypeByStatus($status)
    {
        if (isset($this->typeList[(array) $status])) {
            return $this->typeList[(array) $status];
        }
        return false;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getStatus()
    {
        return $this->status;
    }
}

?>