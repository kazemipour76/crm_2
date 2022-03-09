<?php

namespace App\Utilities;


class Request
{
    public static function hasQuery(array $expect = [])
    {
        return !empty(request()->getQueryString());
    }
}
