<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use TCG\Voyager\Traits\Translatable;

/**
 * App\Sale
 *
 * @property int $id
 * @property string $title
 * @property string|null $excerpt
 * @property string $body
 * @property string $slug
 * @property string $image
 * @property string|null $meta_description
 * @property string|null $seo_title
 * @property string|null $meta_keywords
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read null $translated
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale search($searchTerm)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sale withTranslations($locales = null, $fallback = true)
 */
class Sale extends Model
{
    use Translatable, QueryCacheable;
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    protected $translatable = ['title','excerpt','body','meta_description','seo_title','meta_keywords'];

    protected $dates = ['created_at','updated_at'];


    public static function scopeSearch($query, $searchTerm)
    {
        return $query->where('title', 'like', '%' .$searchTerm. '%')
            ->orWhere('slug', 'like', '%' .$searchTerm. '%');
    }
}
