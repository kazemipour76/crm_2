<?php

namespace App\Models\Auth;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Auth\UserMeta
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $cellphone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta whereCellphone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta whereUserId($value)
 * @mixin \Eloquent
 */
class UserMeta extends BaseModel
{
    use HasFactory;
    protected $table = 'users_meta';
}
