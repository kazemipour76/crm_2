<?php

namespace App\Utilities;


class HString
{

    public static function colon($str)
    {
        return $str . ' : ';
    }

    public static function dividePrice($str, $has_vahed = false, $vahed = 'ریال')
    {
        $arr = str_split(strrev($str), 3);
        $ret = "";
        for ($i = count($arr) - 1; $i >= 0; $i--) {
            $ret .= strrev($arr[$i]);
            if ($i != 0)
                $ret .= ',';
        }
        if ($has_vahed)
            return $ret . ' ' . $vahed;
        return $ret;
    }


    public static function compressPrice($str)
    {
        $str = trim(str_replace("ریال", "", $str));
        return str_replace(",", "", $str);
    }


    public static function number2farsi($srting)
    {
        $en_num = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $fa_num = array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹");
        return str_replace($en_num, $fa_num, $srting);

    }


    public static function number2en($srting)
    {
        $en_num = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $fa_num = array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹");
        return str_replace($fa_num, $en_num, $srting);
    }

    public static function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }

    public static function endsWith($string, $endString)
    {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }

    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
