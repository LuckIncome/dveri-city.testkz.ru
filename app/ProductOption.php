<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use TCG\Voyager\Traits\Translatable;

/**
 * App\ProductOption
 *
 * @property int $id
 * @property int $product_id
 * @property string $option
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductOption whereOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductOption whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductOption whereValue($value)
 * @mixin \Eloquent
 * @property string|null $value_color
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductOption whereValueColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductOption query()
 * @property-read null $translated
 * @property-read \App\Product $productId
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductOption whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductOption withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProductOption withTranslations($locales = null, $fallback = true)
 */
class ProductOption extends Model
{
    use Translatable, QueryCacheable;
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    protected $translatable = ['option','value'];

    public function productId()
    {
        return $this->belongsTo(Product::class);
    }
}
