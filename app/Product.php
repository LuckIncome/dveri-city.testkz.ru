<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use TCG\Voyager\Traits\Resizable;
use TCG\Voyager\Traits\Translatable;

/**
 * App\Product
 *
 * @property int $id
 * @property string $name
 * @property string $brand
 * @property int $category_id
 * @property int $regular_price
 * @property int|null $sale_price
 * @property string $thumb
 * @property string $images
 * @property string|null $excerpt
 * @property string $slug
 * @property string|null $variation_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Category $categoryId
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProductOption[] $options
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereRegularPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereVariationId($value)
 * @mixin \Eloquent
 * @property-read \App\Category $category
 * @property-read mixed $rating
 * @property-read mixed $variants
 * @property-read mixed $variations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProductReview[] $reviews
 * @property-read mixed $link
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product search($searchTerm)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product query()
 * @property int $is_new
 * @property int $is_nestan
 * @property int $featured
 * @property int $stock_count
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $seo_title
 * @property-read int|null $options_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereIsNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereStockCount($value)
 * @property string|null $characteristics
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCharacteristics($value)
 * @property-read null $translated
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product withTranslations($locales = null, $fallback = true)
 * @property string|null $interior_img
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereInteriorImg($value)
 */
class Product extends Model
{
    use Resizable, Translatable, QueryCacheable;

    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;

    protected $translatable = ['name','excerpt','characteristics','seo_title','meta_keywords','meta_description'];

    protected $fillable = ['name','brand','sku','category_id', 'regular_price','sale_price','thumb','images','slug','is_new','is_nestan','featured','stock_count','variation_id','interior_img','excerpt','characteristics','seo_title','meta_keywords','meta_description'];

    public static function scopeSearch($query, $searchTerm)
    {
        return $query->where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('slug', 'like', '%' . $searchTerm . '%')
            ->orWhere('brand', 'like', '%' . $searchTerm . '%');
    }

    public function options()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function hasOption($option_name)
    {
        $hasOption = false;

        if ($this->options->contains('option', $option_name)) {
            $hasOption = true;
        }

        return $hasOption;
    }

    public function categoryId()
    {
        return $this->belongsTo(Category::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getLinkAttribute()
    {
        if ($this->category) {
            return '/catalog/'. $this->category->slug . '/' . $this->slug;
        } else {
            return false;
        }
    }

    public function getVariationsAttribute()
    {
        $variants = unserialize($this->variation_id);
        if ($variants)
            return Product::with('translations')->whereIn('sku', $variants)->get();
        else
            return false;
    }

    public function getVariantsAttribute()
    {
        $locale = session()->get('locale');
        $fallbackLocale = config('app.fallback_locale');
        $variations = $this->variations;
        $variations = $variations ? $variations->translate($locale,$fallbackLocale) : $variations;


        $total = null;

        if ($variations) {
            $options = $this->options;
            $options = $options->translate($locale,$fallbackLocale);
            if ($variations && $options) {
                foreach ($variations as $variation) {
                    foreach ($variation->options as $var_option) {
                        $var_option = $var_option->translate($locale,$fallbackLocale);
                        foreach ($this->options as $option) {
                            $option = $option->translate($locale,$fallbackLocale);
                            if ($option->option == $var_option->option && $option->value != $var_option->value && !$options->contains($var_option)) {
                                if (!$this->checkProductOptions($options, 'value', $var_option->value)) {
                                    $options->push($var_option);
                                }
                            }
                        }
                    }
                    $options->all();
                }
                $total = $options->groupBy('option');

            }

        }


        return $total;
    }

    protected function checkProductOptions($products, $field, $value)
    {
        foreach ($products as $key => $product) {
            if ($product->{$field} === $value) {
                return $value;
            }
        }
        return false;
    }

    protected function checkProductOptionsOption($products, $field, $value)
    {
        foreach ($products as $key => $product) {
            if ($product->{$field} === $value) {
                return $product;
            }
        }
        return false;
    }

    protected function checkProductOptionsExists($products, $field, $value)
    {
        foreach ($products as $key => $product) {
            if ($product->{$field} != $value) {
                return true;
            }
        }
        return false;
    }

    public static function slugify($str,$options = array())
    {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => true,
        );

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',
            // Latin symbols
            '©' => '(c)',
            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            //Kazakh
            'Ә' => 'A','Ғ'=>'G', 'Қ'=>'K', 'Ң'=>'N','Ө'=>'O','Ұ'=>'U','Ү'=>'U','Һ'=>'H','І'=>'I',
            'ә'=>'a', 'ғ'=>'g', 'қ'=>'k', 'ң'=>'n', 'ө'=>'o', 'ұ'=>'u', 'ү'=>'u', 'h'=>'h', 'і'=>'i',
            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',
            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',
            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }

        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }
}
