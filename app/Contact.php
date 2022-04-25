<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use TCG\Voyager\Traits\Translatable;

/**
 * App\Contact
 *
 * @property int $id
 * @property int $is_main
 * @property string $city
 * @property string $type
 * @property string|null $icon
 * @property string $value
 * @property string|null $link
 * @property int $sort_id
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $big_thumb
 * @property-read mixed $thumbic
 * @property-read null $translated
 * @property-read mixed $webp_image
 * @property-write mixed $thumbnail
 * @property-write mixed $thumbnail_small
 * @property-write mixed $webp
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereIsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereSortId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contact withTranslations($locales = null, $fallback = true)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    use Translatable, QueryCacheable;
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    protected $translatable = ['city', 'value'];
}
