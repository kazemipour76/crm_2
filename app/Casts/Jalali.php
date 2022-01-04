<?php

namespace App\Casts;

use App\Utilities\Jdf;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Jalali implements CastsAttributes
{


    private $time;

    public function __construct($time = null)
    {
        $this->time = $time;
    }

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if(strtolower($this->time) === 'time')
        {
            return Jdf::jdate('Y/m/j H:i:s' ,strtotime($value));
        }
        else
        {
            return Jdf::jdate('Y/m/j' ,strtotime($value));
        }
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
