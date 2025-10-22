<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroXmlParser
{
    private $dom = NULL;
    public function __construct($xml)
    {
        $xml = mb_convert_encoding($xml, "UTF-8", "UTF-8,ISO-8859-1");
        $parser = xml_parser_create();
        if (!xml_parse($parser, $xml)) {
            throw new Exception("PagSeguroLibrary XML parsing error: (" . xml_get_error_code($parser) . ") " . xml_error_string(xml_get_error_code($parser)));
        }
        $this->dom = new DOMDocument();
        $this->dom->loadXml($xml);
    }
    public function getResult($node = NULL)
    {
        $result = $this->toArray($this->dom);
        if ($node) {
            if (isset($result[$node])) {
                return $result[$node];
            }
            throw new Exception("PagSeguroLibrary XML parsing error: undefined index [" . $node . "]");
        }
        return $result;
    }
    private function toArray($node)
    {
        $occurrence = [];
        $result = NULL;
        if ($node->hasChildNodes()) {
            foreach ($node->childNodes as $child) {
                if (!isset($occurrence[$child->nodeName])) {
                    $occurrence[$child->nodeName] = NULL;
                }
                $occurrence[$child->nodeName]++;
            }
        }
        if (isset($child)) {
            if ($child->nodeName == "#text") {
                $result = html_entity_decode(htmlentities($node->nodeValue, ENT_COMPAT, "UTF-8"), ENT_COMPAT, "ISO-8859-15");
            } else {
                if ($node->hasChildNodes()) {
                    $children = $node->childNodes;
                    $i = 0;
                    while ($i < $children->length) {
                        $child = $children->item($i);
                        if ($child->nodeName != "#text") {
                            if (1 < $occurrence[$child->nodeName]) {
                                $result[$child->nodeName][] = $this->toArray($child);
                            } else {
                                $result[$child->nodeName] = $this->toArray($child);
                            }
                        } else {
                            if ($child->nodeName == "0") {
                                $text = $this->toArray($child);
                                if (trim($text) != "") {
                                    $result[$child->nodeName] = $this->toArray($child);
                                }
                            }
                        }
                        $i++;
                    }
                }
                if ($node->hasAttributes()) {
                    $attributes = $node->attributes;
                    if (!is_null($attributes)) {
                        foreach ($attributes as $key => $attr) {
                            $result["@" . $attr->name] = $attr->value;
                        }
                    }
                }
            }
            return $result;
        }
        return NULL;
    }
}

?>