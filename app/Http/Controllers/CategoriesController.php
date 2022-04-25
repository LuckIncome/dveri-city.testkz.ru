<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Seopage;

class CategoriesController extends Controller
{
    public function catalog()
    {
        $locale = session()->get('locale');
        $fallbackLocale = config('app.fallback_locale');
        $featuredProducts = Product::where('featured', true)->orderBy('id', 'desc')->get()->take(12);
//        $featuredProducts = $featuredProducts->translate($locale,$fallbackLocale);

        $newProducts = Product::where('is_new', true)->orderBy('id', 'desc')->get()->take(12);
//        $newProducts = $newProducts->translate($locale,$fallbackLocale);

        $saleProducts = Product::whereNotNull('sale_price')->orWhere('sale_price' ,'>',0)->get()->take(12);
//        $saleProducts = $saleProducts->translate($locale,$fallbackLocale);

        $catalog = Category::whereNotNull('parent_id')->orderBy('order')->get();

        return view('products.catalog', compact('featuredProducts','saleProducts','newProducts','catalog'));
    }

    public function catalogAccessories()
    {
        $catSlug = 'aksessuary';
        $category = Category::with('products')->with('parent')->where('slug', $catSlug)->first();
        $seo_page = Seopage::where('slug', \Request::url());
        if ($seo_page->exists()) {
            $seoTitle = $category->seo_title ? $category->seo_title : ($seo_page->first()->meta_title ? $seo_page->first()->meta_title : $category->name);
            $keywords = $category->meta_keywords ? $category->meta_keywords : ($seo_page->first()->meta_keywords ? $seo_page->first()->meta_keywords : '');
            $description = $category->meta_description ? $category->meta_description : ($seo_page->first()->meta_description ? $seo_page->first()->meta_description : '');
            $seoText = $category->description ? $category->description : ($seo_page->first()->content ? $seo_page->first()->content : '');
        } else {
            $seoTitle = $category->seo_title ? $category->seo_title : $category->name;
            $keywords = $category->meta_keywords ? $category->meta_keywords : '';
            $description = $category->meta_description ? $category->meta_description : '';
            $seoText = $category->description ? $category->description : '';
        }

        $category->setAttribute('seo_title', $seoTitle);
        $category->setAttribute('meta_keywords', $keywords);
        $category->setAttribute('meta_description', $description);
        $category->setAttribute('seoText', $seoText);
        return view('products.index', compact('category'));
    }

    public function getCurrentCategory($slug)
    {
        $category = Category::with('translations')->with('parent')->where('slug', $slug)->first();
        $category = $category->translate(session()->get('locale'),config('app.fallback_locale'));
        return response()->json(['category'=>$category]);
    }

    public function index($catSlug)
    {
        $locale = session()->get('locale');
        $fallbackLocale = config('app.fallback_locale');
        $category = Category::with(['products','translations'])->with('parent')->where('slug', $catSlug)->first();
        $seo_page = Seopage::where('slug', \Request::url());
        if ($seo_page->exists()) {
            $seoTitle = $category->seo_title ? $category->seo_title : ($seo_page->first()->meta_title ? $seo_page->first()->meta_title : $category->name);
            $keywords = $category->meta_keywords ? $category->meta_keywords : ($seo_page->first()->meta_keywords ? $seo_page->first()->meta_keywords : '');
            $description = $category->meta_description ? $category->meta_description : ($seo_page->first()->meta_description ? $seo_page->first()->meta_description : '');
            $seoText = $category->description ? $category->description : ($seo_page->first()->content ? $seo_page->first()->content : '');
        } else {
            $seoTitle = $category->seo_title ? $category->seo_title : $category->name;
            $keywords = $category->meta_keywords ? $category->meta_keywords : '';
            $description = $category->meta_description ? $category->meta_description : '';
            $seoText = $category->description ? $category->description : '';
        }

        $category->setAttribute('seo_title', $seoTitle);
        $category->setAttribute('meta_keywords', $keywords);
        $category->setAttribute('meta_description', $description);
        $category->setAttribute('seoText', $seoText);
        $categories = Category::with('translations')->whereNotNull('parent_id')->get();
        $category = $category->translate($locale, $fallbackLocale);
        $categories = $categories->translate($locale, $fallbackLocale);
        return view('products.index', compact('category', 'categories'));
    }

    public function getSubcats($catSlug, $subcatSlug)
    {
        $category = Category::with('products')->with('parent')->where('slug', $subcatSlug)->first();
        $seo_page = Seopage::where('slug', \Request::url());
        if ($seo_page->exists()) {
            $seoTitle = $category->seo_title ? $category->seo_title : ($seo_page->first()->meta_title ? $seo_page->first()->meta_title : $category->name);
            $keywords = $category->meta_keywords ? $category->meta_keywords : ($seo_page->first()->meta_keywords ? $seo_page->first()->meta_keywords : '');
            $description = $category->meta_description ? $category->meta_description : ($seo_page->first()->meta_description ? $seo_page->first()->meta_description : '');
            $seoText = $category->description ? $category->description : ($seo_page->first()->content ? $seo_page->first()->content : '');
        } else {
            $seoTitle = $category->seo_title ? $category->seo_title : $category->name;
            $keywords = $category->meta_keywords ? $category->meta_keywords : '';
            $description = $category->meta_description ? $category->meta_description : '';
            $seoText = $category->description ? $category->description : '';
        }

        $category->setAttribute('seo_title', $seoTitle);
        $category->setAttribute('meta_keywords', $keywords);
        $category->setAttribute('meta_description', $description);
        $category->setAttribute('seoText', $seoText);
        return view('products.index', compact('category'));
    }

    public function getProducts($categoryId)
    {
        $locale = session()->get('locale');
        $fallbacklocale = config('app.fallback_locale');
        $products = Product::with(['options','category'])
            ->whereCategoryId($categoryId)
            ->select('sale_price','id','regular_price','thumb','category_id','slug','brand','name','stock_count')
            ->get();
//       $products = Category::find($categoryId)->products;
        $compare = app('compare');
        $options = [];
        if ($products->count()) {
            foreach ($products as $product) {
                if ($product->sale_price) {
                    $product->setAttribute('price', $product->sale_price);
                } else {
                    $product->setAttribute('price', $product->regular_price);
                    $product->sale_price = 0;
                }
                $product->setAttribute('link', '/catalog/' . $product->category->slug . '/' . $product->slug);
                $thumbnail = str_replace(pathinfo(\Voyager::image($product->thumb),PATHINFO_EXTENSION),'webp',\Voyager::image($product->thumb));
                $thumbnail = \Storage::exists('public/'.str_replace(\URL::to('/').'/storage','',$thumbnail)) ? $thumbnail : \Voyager::image($product->thumb);
                $product->setAttribute('image_link', \Voyager::image($product->thumb));
                $product->setAttribute('thumb_link', $thumbnail);
                $product->setAttribute('inCompare', ($compare->get($product->id) !== null));
                foreach ($product->options as $option) {
                    $option = $option->translate($locale,$fallbacklocale);
                    $options[] = $option;
                    $product->setAttribute($option->option, $option->value);
                }
            }
            $products = $products->translate($locale,$fallbacklocale);

            $brands = $products->groupBy('brand')->keys();
            $options_key = collect($options)->groupBy('option')->keys();
            $options = collect($options)->unique('value')->groupBy('option');
            $result_options = [];
            foreach ($brands as $brand) {
                $result_options['brand'][$brand] = false;
            }
            foreach ($options as $key => $option) {
                foreach ($option as $item) {
                    $result_options[$key][$item->value] = false;
                }
            }
            foreach ($result_options as $k => $opt) {
                ksort($result_options[$k]);
            }

            $result_options['price']['max'] = $products->max('price');
            $result_options['price']['min'] = $products->min('price');


            return response()->json(['products' => $products, 'options_key' => $options_key, 'options' => $options, 'brands' => $brands, 'filters' => $result_options]);
        } else {
            return response()->json(['products' => null]);
        }

    }
}
