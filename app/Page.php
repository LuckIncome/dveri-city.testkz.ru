<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * App\Page
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string|null $excerpt
 * @property string|null $body
 * @property string|null $image
 * @property string $slug
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page search($searchTerm)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page query()
 * @property string|null $seo_title
 * @property-read null $translated
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\TCG\Voyager\Models\Page active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\TCG\Voyager\Models\Page whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\TCG\Voyager\Models\Page withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\TCG\Voyager\Models\Page withTranslations($locales = null, $fallback = true)
 */
class Page extends \TCG\Voyager\Models\Page
{
    use QueryCacheable;
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    protected $translatable = ['title', 'excerpt', 'body','meta_description','meta_keywords','seo_title'];

    public static function scopeSearch($query, $searchTerm)
    {
        return $query->where('title', 'like', '%' .$searchTerm. '%')
            ->orWhere('slug', 'like', '%' .$searchTerm. '%');
    }
}
