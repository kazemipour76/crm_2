<?php


namespace App\Models\Auth;

use App\Casts\Jalali;
use App\Models\BaseModel;
use App\Traits\FullTextSearch;
use Database\Factories\UserFactory;
use Faker\Provider\Base;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * App\Models\Auth\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $remember_token
 * @property string|null $remember_token_time_creat
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberTokenTimeCreat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|User kazemi($name)
 * @method static \Illuminate\Database\Eloquent\Builder|User search($term)
 */
class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use
        \Illuminate\Auth\Authenticatable,
        \Illuminate\Foundation\Auth\Access\Authorizable,
        \Illuminate\Auth\Passwords\CanResetPassword,
        \Illuminate\Auth\MustVerifyEmail,
        HasFactory, FullTextSearch;

    protected $table = "users";
    protected $searchable = [
        'name',
        'email'
    ];

    protected $fillable = [
        'name',
        'email',
    ];

    protected $casts = [
        'updated_at' => Jalali::class . ':time',
        'created_at' => Jalali::class . ':time',
    ];

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    public function scopeKazemi($q, $name)
    {
        $q->where('fadakar', $name);
        return $q;
    }

    public static function getValidationRules($idEdit = false, $id = null)
    {

        $rules = [
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|email|not_regex:/(^([a-zA-z]+)(\d+)?$)/u|unique:users',

        ];
        if ($idEdit) {
            $rules ['password'] = '';
            $rules ['name'] = 'required:users,id,:id';
            $rules['email'] = 'required|email|not_regex:/(^([a-zA-z]+)(\d+)?$)/u|unique:users,email,' . $id;

        }
        return $rules;
    }
}
