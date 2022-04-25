<?php

namespace App\Http\Controllers;

use App\Category;
use App\HomeRender;
use App\HomeSlider;
use App\Page;
use App\Post;
use App\Product;
use App\Sale;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $locale = session()->get('locale');
        $fallbackLocale = config('app.fallback_locale');
        $slidersT = HomeSlider::where('status', true)->orderBy('order', 'ASC')->get();
        $renders = HomeRender::where('status', true)->orderBy('order', 'ASC')->take(4)->get();

        $sliders = $slidersT->translate($locale,$fallbackLocale);
        $renders = $renders->translate($locale,$fallbackLocale);

        $posts = Post::with('translations')->where('status', Post::PUBLISHED)->orderBy('created_at', 'DESC')->take(4)->get()->each(function ($item) use($locale,$fallbackLocale) {
            $item->excerpt = (strlen($item->getTranslatedAttribute('excerpt',$locale,$fallbackLocale)) > 1) ? \Str::words($item->getTranslatedAttribute('excerpt',$locale,$fallbackLocale), 15, ' ...') : \Str::words($item->getTranslatedAttribute('body',$locale,$fallbackLocale), 15, ' ...');
        });
        $posts = $posts->translate($locale,$fallbackLocale);

        $featuredProducts = Product::where('featured', true)->orderBy('id', 'desc')->get()->take(12);
//        $featuredProducts = $featuredProducts->translate($locale,$fallbackLocale);

        $newProducts = Product::where('is_new', true)->orderBy('id', 'desc')->get()->take(12);
//        $newProducts = $newProducts->translate($locale,$fallbackLocale);

        $saleProducts = Product::whereNotNull('sale_price')->orWhere('sale_price' ,'>',0)->orderBy('id', 'desc')->get()->take(12);
//        $saleProducts = $saleProducts->translate($locale,$fallbackLocale);
        
        $nestanProducts = Product::where('is_nestan', true)->orderBy('id', 'desc')->get()->take(12);
        
        $catalog = Category::with('subcategories')->whereSlug('dveri')->orderBy('order')->first();
        $furniture = Category::with('subcategories')->whereSlug('furnitura')->orderBy('order')->first();
        $catalog->subcategories = $catalog->subcategories->translate($locale,$fallbackLocale);
        $furniture->subcategories = $furniture->subcategories->translate($locale,$fallbackLocale);
        $catalog = $catalog->translate($locale,$fallbackLocale);
        $furniture = $furniture->translate($locale,$fallbackLocale);

        return view('home', compact('sliders', 'slidersT','renders', 'featuredProducts', 'newProducts', 'saleProducts', 'posts', 'locale', 'fallbackLocale','catalog', 'furniture'));
    }

    public function search(Request $request)
    {
        $input = $request->get('input');
        $categories = Category::search($input)->whereNotNull('parent_id')->select('name', 'slug')->get();
        $products = Product::search($input)->select('name', 'brand', 'slug', 'category_id')->with('category')->get();
        $pages = Page::search($input)->select('title', 'slug')->get();
        $posts = Post::search($input)->select('title', 'slug')->get();
        $sales = Sale::search($input)->select('title', 'slug')->get();

        $collection = collect($pages)->merge($products)->merge($categories)->merge($posts)->merge($sales);
        foreach ($collection as $item) {
            switch (class_basename($item)) {
                case 'Category':
                    $item->setAttribute('full_link', env('APP_URL') . '/catalog/' . $item->slug);
                    $item->setAttribute('item', 'Каталог');
                    break;
                case 'Product':
                    $item->setAttribute('full_link', env('APP_URL') . '/catalog/' . $item->category->slug . '/' . $item->slug);
                    $item->setAttribute('item', 'Товар');
                    break;
                case 'Page':
                    $item->setAttribute('full_link', env('APP_URL') . '/page/' . $item->slug);
                    $item->setAttribute('name', $item->title);
                    $item->setAttribute('item', 'Страница');
                    break;
                case 'Post':
                    $item->setAttribute('full_link', env('APP_URL') . '/news/' . $item->slug);
                    $item->setAttribute('name', $item->title);
                    $item->setAttribute('item', 'Статья');
                    break;
                case 'Sale':
                    $item->setAttribute('full_link', env('APP_URL') . '/sales/' . $item->slug);
                    $item->setAttribute('name', $item->title);
                    $item->setAttribute('item', 'Акция');
                    break;
            }
        }

        return response()->json(['items' => $collection]);
    }

    public function test()
    {
        return view('test');
    }
}
