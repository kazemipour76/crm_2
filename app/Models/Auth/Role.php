<?php

namespace App\Models\Auth;


use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * App\Models\Auth\Role
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 */
class Role extends BaseModel
{
    protected $table = "roles";
}
