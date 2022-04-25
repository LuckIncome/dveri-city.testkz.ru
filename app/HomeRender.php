<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use TCG\Voyager\Traits\Translatable;

/**
 * App\HomeRender
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $image
 * @property int|null $order
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeRender whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeRender whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeRender whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeRender whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeRender whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeRender whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeRender whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeRender whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeRender newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeRender newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeRender query()
 * @property-read null $translated
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeRender whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeRender withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeRender withTranslations($locales = null, $fallback = true)
 */
class HomeRender extends Model
{
    use Translatable, QueryCacheable;
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    protected $translatable = ['title', 'description'];

}
