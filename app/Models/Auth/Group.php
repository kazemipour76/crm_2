<?php


namespace App\Models\Auth;

use App\Casts\Jalali;
use App\Models\BaseModel;
use App\Traits\FullTextSearch;
use Database\Factories\GroupFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * App\Models\Auth\Group
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property mixed|null $updated_at
 * @method static \Database\Factories\GroupFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder|Group search($term)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Group extends BaseModel
{
    use HasFactory, FullTextSearch;

    protected $table = "groups";
    protected $searchable = [
        'name',

    ];

    protected $fillable = [
        'name',
           ];

    protected $casts = [
        'updated_at' => Jalali::class . ':time',
        'created_at' => Jalali::class . ':time',

    ];

    protected static function newFactory()
    {
        return GroupFactory::new();
    }

    public static function getValidationRules($idEdit = false, $id = null)
    {

        $rules = [
            'name' => 'required',


        ];
        if ($idEdit) {


        }
        return $rules;
    }
}
