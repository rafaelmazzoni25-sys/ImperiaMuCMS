<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroMetaDataItemKeys
{
    private static $availableItemKeysList = ["PASSENGER_CPF" => "CPF do passageiro", "PASSENGER_PASSPORT" => "Passaporte do passageiro", "ORIGIN_CITY" => "Cidade de origem", "DESTINATION_CITY" => "Cidade de destino", "ORIGIN_AIRPORT_CODE" => "Código do aeroporto de origem", "DESTINATION_AIRPORT_CODE" => "Código do aeroporto de destino", "GAME_NAME" => "Nome do jogo", "PLAYER_ID" => "Id do jogador", "TIME_IN_GAME_DAYS" => "Tempo no jogo em dias", "MOBILE_NUMBER" => "Celular de recarga", "PASSENGER_NAME" => "Nome do passageiro"];
    public static function getAvailableItemKeysList()
    {
        return self::$availableItemKeysList;
    }
    public static function isItemKeyAvailable($itemKey)
    {
        $itemKey = strtoupper($itemKey);
        return isset(self::$availableItemKeysList[$itemKey]);
    }
    public static function getItemDescriptionByKey($itemKey)
    {
        $itemKey = strtoupper($itemKey);
        if (isset(self::$availableItemKeysList[$itemKey])) {
            return self::$availableItemKeysList[$itemKey];
        }
        return false;
    }
    public static function getItemKeyByDescription($itemDescription)
    {
        return array_search(strtolower($itemDescription), array_map("strtolower", self::$availableItemKeysList));
    }
}

?>