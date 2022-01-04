<?php

namespace App\Models\Auth;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * App\Models\Auth\Permission
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $name
 * @property string|null $key
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 */
class Permission extends Model
{

    protected $table = "permissions";

}
