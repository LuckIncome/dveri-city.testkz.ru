<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use TCG\Voyager\Traits\Translatable;

/**
 * App\Category
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int $order
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read null $translated
 * @property-read \App\Category|null $parent
 * @property-read \TCG\Voyager\Models\Category $parentId
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Post[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Category[] $subcategories
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\TCG\Voyager\Models\Category withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\TCG\Voyager\Models\Category withTranslations($locales = null, $fallback = true)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category search($searchTerm)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category query()
 * @property-read int|null $posts_count
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products_parent
 * @property-read int|null $products_parent_count
 * @property-read int|null $subcategories_count
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\TCG\Voyager\Models\Category whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @property string|null $description
 * @property string|null $image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereImage($value)
 */
class Category extends \TCG\Voyager\Models\Category
{
    use QueryCacheable;
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    protected $translatable = ['name'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function subcategoriesRecursive()
    {
        return $this->subcategories()->with('subcategoriesRecursive');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function products_parent()
    {
        return $this->hasManyThrough(Product::class, Category::class, 'parent_id', 'category_id', 'id');
    }

    public static function scopeSearch($query, $searchTerm)
    {
        return $query->where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('slug', 'like', '%' . $searchTerm . '%');
    }

    public static function getAllProducts($categoryId, $products = null)
    {
        if ($products === null) {
            $products = collect();
        }
        $category = Category::find($categoryId);

        $products = $products->merge($category->products);
        foreach ($category->subcategoriesRecursive as $child) {
            $products = self::getAllProducts($child->id, $products);
        }
        return $products;
    }
}
