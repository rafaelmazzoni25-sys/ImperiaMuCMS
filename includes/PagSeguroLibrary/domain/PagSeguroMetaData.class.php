<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroMetaData
{
    private $items = NULL;
    public function __construct($items = NULL)
    {
        if (!is_null($items) && 0 < count($items)) {
            $this->setItems($items);
        }
    }
    public function addItem(PagSeguroMetaDataItem $metaDataItem)
    {
        $this->items[] = $metaDataItem;
    }
    public function getItems()
    {
        if ($this->items == NULL) {
            $this->items = [];
        }
        return $this->items;
    }
    public function setItems($items)
    {
        $this->items = $items;
    }
}

?>