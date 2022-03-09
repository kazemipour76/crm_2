<?php

namespace App\Utilities;

use Illuminate\Support\Facades\Route;

class Routers
{
    public static function crud($path, $controller, array $options = [])
    {
        $defaultOptions = [
            'index' => true,
            'create' => true,
            'edit' => true,
            'destroy' => true,
        ];
        $options = array_merge($defaultOptions, $options);
        if ($options['index'])
            Route::get("$path", [$controller, 'index']);
        if ($options['index'])
            Route::post("$path", [$controller, 'actions']);
        if ($options['create'])
            Route::get("$path/create", [$controller, 'create']);
        if ($options['create'])
            Route::post("$path/create", [$controller, 'store']);
        if ($options['edit'])
            Route::get("$path/{id}/edit", [$controller, 'edit']);
        if ($options['edit'])
            Route::post("$path/{id}/edit", [$controller, 'update']);
        if ($options['destroy'])
            Route::get("$path/{id}/delete", [$controller, 'destroy']);
    }
}
