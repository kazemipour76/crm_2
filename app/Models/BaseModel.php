<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{

    protected $idGenerator = false;
    protected $searchable = [];

    public static function generateNewId()
    {
        $prefix = "1";
        $id = $prefix . str_replace('.', '', microtime(true)) . rand(1, 99);
        if (self::where('id', '=', $id)->count() > 0) {
            usleep(rand(100, 1000));
            return self::generateNewId();
        }
        return $id;
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if ($model->idGenerator === true) {
                $model->id = self::generateNewId();
            }
        });

    }

}
