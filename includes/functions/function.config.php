<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

function config($config_name, $return = false)
{
    global $config;
    if ($return) {
        return $config[$config_name];
    }
    echo $config[$config_name];
}
function utf8ize($d)
{
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else {
        if (is_string($d)) {
            return utf8_encode($d);
        }
    }
    return $d;
}
function convertXML($object)
{
    return json_decode(json_encode(utf8ize($object), JSON_FORCE_OBJECT), true);
}
function loadModuleConfigs($module)
{
    global $mconfig;
    if (moduleConfigExists($module)) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . $module . ".xml");
        $mconfig = [];
        if ($xml) {
            $moduleCONFIGS = convertxml($xml->children());
            $mconfig = $moduleCONFIGS;
        }
    }
}
function moduleConfigExists($module)
{
    if (file_exists(__PATH_MODULE_CONFIGS__ . $module . ".xml")) {
        return true;
    }
}
function globalConfigExists($config_file)
{
    if (file_exists(__PATH_CONFIGS__ . $config_file . ".xml")) {
        return true;
    }
}
function mconfig($configuration)
{
    global $mconfig;
    if (@array_key_exists($configuration, $mconfig)) {
        return $mconfig[$configuration];
    }
    return NULL;
}
function gconfig($config_file, $return = true)
{
    global $gconfig;
    if (globalconfigexists($config_file)) {
        $xml = simplexml_load_file(__PATH_CONFIGS__ . $config_file . ".xml");
        $gconfig = [];
        if ($xml) {
            $globalCONFIGS = removeEmptyArray(convertxml($xml->children()));
            if ($return) {
                return $globalCONFIGS;
            }
            $gconfig = $globalCONFIGS;
        }
    }
}
function removeEmptyArray($a)
{
    if (is_array($a)) {
        if (count($a) == 0) {
            $a = "";
        } else {
            foreach ($a as $k => $v) {
                $a[$k] = removeEmptyArray($v);
            }
        }
    }
    return $a;
}
function loadConfigurations($file)
{
    if (!check_value($file)) {
        return NULL;
    }
    if (!moduleconfigexists($file)) {
        return NULL;
    }
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . $file . ".xml");
    if ($xml) {
        return convertxml($xml->children());
    }
    return NULL;
}

?>