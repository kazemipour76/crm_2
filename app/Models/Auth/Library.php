<?php


namespace App\Models\Auth;

use App\Casts\Jalali;
use App\Exceptions\FileUploadException;
use App\Traits\FullTextSearch;
use App\Utilities\UploadHandler;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\See;

/**
 * App\Models\Auth\Library
 * 
 * // * @property int $id
 * // * @property string $file_name
 * // * @property string $ext
 * // * @property string $title
 * // * @property string|null $caption
 * // * @property string|null $description
 * // * @property string|null $slug
 * // * @property string $path
 * // * @property string $folder
 * // * @property string $size
 * // * @property int $user_id
 * // * @property \Illuminate\Support\Carbon|null $created_at
 * // * @property \Illuminate\Support\Carbon|null $updated_at
 * // * @property-read mixed $full_path
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library newModelQuery()
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library newQuery()
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library query()
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library whereCaption($value)
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library whereCreatedAt($value)
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library whereDescription($value)
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library whereExt($value)
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library whereFileName($value)
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library whereFolder($value)
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library whereId($value)
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library wherePath($value)
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library whereSize($value)
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library whereSlug($value)
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library whereTitle($value)
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library whereUpdatedAt($value)
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library whereUserId($value)
 * // * @mixin \Eloquent
 * // * @property-read mixed $full_file_name
 * // * @property-read mixed $full_path_asset
 * // * @property string $sub_folder
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library whereSubFolder($value)
 * // * @method static \Illuminate\Database\Eloquent\Builder|Library search($term)
 *
 * @property int $id
 * @property string $file_name
 * @property string $ext
 * @property string $folder
 * @property string $path
 * @property string $size
 * @property string $title
 * @property string|null $caption
 * @property string|null $description
 * @property string|null $slug
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_file_name
 * @property-read mixed $full_path_asset
 * @property-read mixed $full_path
 * @method static \Illuminate\Database\Eloquent\Builder|Library newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Library newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Library query()
 * @method static \Illuminate\Database\Eloquent\Builder|Library search($term)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereUserId($value)
 * @mixin \Eloquent
 */
class Library extends Model
{
    use  FullTextSearch;

    protected $table = 'libraries';

    protected $searchable = [
        'file_name',
        'title',
        'caption',
        'description',

    ];

    protected $fillable = [
        'file_name',
        'title',
        'caption',
        'description',
    ];

    public function getFullPathAssetAttribute()
    {

        return asset("storage/uploads/{$this->full_path}");
    }


    public function getFullPathAttribute()
    {

        return "{$this->path}/{$this->full_file_name}";
    }

    public function getFullFileNameAttribute()
    {

        return "{$this->file_name}.{$this->ext}";
    }

    public static function getValidationRules()
    {
        $rules = [
            'name' => 'required',
        ];
        return $rules;
    }

}


