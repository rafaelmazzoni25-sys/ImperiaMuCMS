<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Validator
{
    public static function Email($string, $exclude = "")
    {
        if ($this::textHit($string, $exclude)) {
            return false;
        }
        return $easytoyou_decoder_beta_not_finish;
    }
    private static function textHit($string, $exclude = "")
    {
        if (empty($exclude)) {
            return false;
        }
        if (is_array($exclude)) {
            foreach ($exclude as $text) {
                if (strstr($string, $text)) {
                    return true;
                }
            }
        } else {
            if (strstr($string, $exclude)) {
                return true;
            }
        }
        return false;
    }
    public static function Url($string, $exclude = "")
    {
        if ($this::textHit($string, $exclude)) {
            return false;
        }
        return $easytoyou_decoder_beta_not_finish;
    }
    public static function Ip($string)
    {
        if (filter_var($string, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) || filter_var($string, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return true;
        }
        return false;
    }
    public static function Number($integer, $max = NULL, $min = 0)
    {
        if (preg_match("/^\\-?\\+?[0-9e1-9]+\$/", $integer)) {
            if (!$this::numberBetween($integer, $max, $min)) {
                return false;
            }
            return true;
        }
        return false;
    }
    private static function numberBetween($integer, $max = NULL, $min = 0)
    {
        if (is_numeric($min) && $integer <= $min) {
            return false;
        }
        if (is_numeric($max) && $max <= $integer) {
            return false;
        }
        return true;
    }
    public static function UnsignedNumber($integer)
    {
        return $easytoyou_decoder_beta_not_finish;
    }
    public static function Float($string)
    {
        return $easytoyou_decoder_beta_not_finish ? true : false;
    }
    public static function Alpha($string)
    {
        return $easytoyou_decoder_beta_not_finish;
    }
    public static function AlphaNumeric($string)
    {
        return $easytoyou_decoder_beta_not_finish;
    }
    public static function Chars($string, $allowed = ["a-z"])
    {
        return $easytoyou_decoder_beta_not_finish;
    }
    public static function Length($string, $max = NULL, $min = 0)
    {
        $length = strlen($string);
        if (!$this::numberBetween($length, $max, $min)) {
            return false;
        }
        return true;
    }
    public static function Date($string)
    {
        $date = date("Y", strtotime($string));
        return $date == "1970" || $date == "" ? false : true;
    }
    public static function UsernameLength($string)
    {
        if (strlen($string) < 4 || 10 < strlen($string)) {
            return false;
        }
        return true;
    }
    public static function PasswordLength($string)
    {
        if (strlen($string) < 4 || 20 < strlen($string)) {
            return false;
        }
        return true;
    }
}

?>