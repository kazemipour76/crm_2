<?php


namespace App\Utilities;


class Url
{
    public static function getAdminPrefix()
    {
        return 'sadmin';
    }


    public static function admin($url){
        $adminPrefix = self::getAdminPrefix();
        $url = trim($url, '/');
        return url("$adminPrefix/{$url}");
    }
}
