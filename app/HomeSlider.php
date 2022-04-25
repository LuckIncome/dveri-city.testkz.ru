<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use TCG\Voyager\Traits\Resizable;
use TCG\Voyager\Traits\Translatable;


/**
 * App\HomeSlider
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $button
 * @property string|null $button_link
 * @property string|null $image
 * @property int|null $order
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider whereButton($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider whereButtonLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider query()
 * @property string|null $image_gallery
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider whereImageGallery($value)
 * @property-read null $translated
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HomeSlider withTranslations($locales = null, $fallback = true)
 */
class HomeSlider extends Model
{
    use Translatable, Resizable, QueryCacheable;
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    protected $translatable = ['title', 'description', 'button'];
}
