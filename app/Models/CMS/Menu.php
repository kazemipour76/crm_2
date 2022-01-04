<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Models\CMS\Menu
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $library_id
 * @property string $title
 * @property string $order
 * @property string|null $link
 * @property string|null $icon
 * @property int $isBold
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIsBold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLibraryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Menu extends Model
{
    protected $table = 'menus';

    public static function getTree()
    {

        $models = self::all();
        $parents = collect($models->where('parent_id', null)->all());
        return self::makeTree($parents, $models);
    }

    public static function makeTree(Collection $collection, Collection $all)
    {
        $ret = collect([]);
        foreach ($collection as $item) {
            $children = collect($all->where('parent_id', $item->id)->all());
            if ($children->count() > 0) {
                $item['children'] = self::makeTree($children, $all);
                $ret->push($item->toArray());
            } else {
                $ret->push($item->toArray());
            }
        }

        return $ret->toArray();
    }

    public static function getValidationRules($idEdit = false, $id = null)
    {

        $rules = [
            'title' => 'required',
        ];
        if ($idEdit) {
            $rules ['name'] = 'required:users,id,:id';
        }
        return $rules;
    }
}
