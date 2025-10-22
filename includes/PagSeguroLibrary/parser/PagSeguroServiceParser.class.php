<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroServiceParser
{
    public static function readErrors($str_xml)
    {
        $parser = new PagSeguroXmlParser($str_xml);
        $data = $parser->getResult("errors");
        $errors = [];
        if (isset($data["error"]) && is_array($data["error"])) {
            if (isset($data["error"]["code"]) && isset($data["error"]["message"])) {
                array_push($errors, new PagSeguroError($data["error"]["code"], $data["error"]["message"]));
            } else {
                foreach ($data["error"] as $key => $value) {
                    if (isset($value["code"]) && isset($value["message"])) {
                        array_push($errors, new PagSeguroError($value["code"], $value["message"]));
                    }
                }
            }
        }
        return $errors;
    }
}

?>