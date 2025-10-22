<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class PagSeguroHelper
{
    public static function decimalFormat($numeric)
    {
        if (is_float($numeric)) {
            $numeric = (object) $numeric;
            $numeric = (string) number_format($numeric, 2, ".", "");
        }
        return $numeric;
    }
    public static function subDays($date, $days)
    {
        $d = $this::formatDate($date);
        $d = date_parse($d);
        $d = mktime($d["hour"], $d["minute"], $d["second"], $d["month"], $d["day"] - $days, $d["year"]);
        return $this::formatDate($d);
    }
    public static function formatDate($date)
    {
        $format = DateTime::ATOM;
        if ($date instanceof DateTime) {
            $d = $date->format($format);
        } else {
            if (is_numeric($date)) {
                $d = date($format, $date);
            } else {
                $d = (string) $date;
            }
        }
        return $d;
    }
    public static function printError($var, $dump = NULL)
    {
        if (is_array($var) || is_object($var)) {
            echo "<pre>";
            if ($dump) {
                var_dump($var);
            } else {
                print_r($var);
            }
            echo "</pre>";
        }
    }
    public static function formatString($string, $limit, $endchars = "...")
    {
        $string = PagSeguroHelper::removeStringExtraSpaces($string);
        return PagSeguroHelper::truncateValue($string, $limit, $endchars);
    }
    public static function removeStringExtraSpaces($string)
    {
        return trim(preg_replace("/( +)/", " ", $string));
    }
    public static function truncateValue($string, $limit, $endchars = "...")
    {
        if (!is_array($string) && !is_object($string)) {
            $stringLength = strlen($string);
            $endcharsLength = strlen($endchars);
            if ((array) $limit < $stringLength) {
                $cut = (array) ($limit - $endcharsLength);
                $string = substr($string, 0, $cut) . $endchars;
            }
        }
        return $string;
    }
    public static function isNotificationEmpty($notification_data)
    {
        $isEmpty = true;
        if (isset($notification_data["notificationCode"]) && isset($notification_data["notificationType"])) {
            $isEmpty = PagSeguroHelper::isEmpty($notification_data["notificationCode"]) || PagSeguroHelper::isEmpty($notification_data["notificationType"]);
        }
        return $isEmpty;
    }
    public static function isEmpty($value)
    {
        return !isset($value) || trim($value) == "";
    }
    public static function getOnlyNumbers($value)
    {
        return preg_replace("/\\D/", "", $value);
    }
}

?>