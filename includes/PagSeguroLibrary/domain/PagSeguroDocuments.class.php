<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroDocuments
{
    private static $availableDocumentList = ["CPF" => "Cadastro de Pessoa Física"];
    public static function getAvailableDocumentList()
    {
        return self::$availableDocumentList;
    }
    public static function isDocumentTypeAvailable($documentType)
    {
        $documentType = strtoupper($documentType);
        return isset(self::$availableDocumentList[$documentType]);
    }
    public static function getDocumentByType($documentType)
    {
        $documentType = strtoupper($documentType);
        if (isset(self::$availableDocumentList[$documentType])) {
            return self::$availableDocumentList[$documentType];
        }
        return false;
    }
    public static function getDocumentByDescription($documentDescription)
    {
        return array_search(strtolower($documentDescription), array_map("strtolower", self::$availableDocumentList));
    }
}

?>