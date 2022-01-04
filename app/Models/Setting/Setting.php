<?php


namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;


/**
 * App\Models\Setting\Setting
 *
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    const CACHE_KEY = 'platform_settings';
    const TYPE_INPUT_TEXT = 1;
    const TYPE_INPUT_EMAIL = 2;
    const TYPE_INPUT_URL = 3;
    const TYPE_INPUT_RADIO = 5;
    const TYPE_INPUT_COLOR = 6;

    const TYPE_TEXTAREA = 7;
    const TYPE_CHECKBOX = 4;
    const TYPE_SELECT = 8;
    const TYPE_SWITCH = 9;

    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $table = 'settings';


    public static function get($key)
    {
        $settings = Cache::get(self::CACHE_KEY);
        if (empty($settings)) {
            $dbSettings = Setting::all()->pluck('value', 'key');
            Cache::forever(self::CACHE_KEY, $dbSettings->toArray());
            $settings=$dbSettings;
        }
        return $settings[$key];
    }


}


