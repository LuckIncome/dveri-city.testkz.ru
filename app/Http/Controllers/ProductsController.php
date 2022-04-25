<?php

namespace App\Http\Controllers;

use App\Product;
use function GuzzleHttp\Psr7\str;

class ProductsController extends Controller
{
    public function show($subcatSlug,$productSlug)
    {
        $locale = session()->get('locale');
        $fallbackLocale = config('app.fallback_locale');
        $compare = app('compare');
        $productT = Product::with('translations')->whereSlug($productSlug)->first();
        $productT->setAttribute('chars',unserialize($productT->getTranslatedAttribute('characteristics',$locale,$fallbackLocale)));
        $thumbnail = str_replace(pathinfo(\Voyager::image($productT->thumb), PATHINFO_EXTENSION),'webp',\Voyager::image($productT->thumb));
        $thumbnail = \Storage::exists('public/'.str_replace(\URL::to('/').'/storage','',$thumbnail)) ? $thumbnail : \Voyager::image($productT->thumb);
        $productT->setAttribute('thumbnail', $thumbnail);
        $productT->setAttribute('inCompare', ($compare->get($productT->id) !== null));
        $product = $productT->translate($locale,$fallbackLocale);
        $featuredProducts = Product::with(['translations','category'])->where('featured',true)->take(20)->get();
        foreach ($featuredProducts as $featuredProduct){
            $thumbnail = str_replace(pathinfo(\Voyager::image($featuredProduct->getThumbnail($featuredProduct->thumb, 'small')))['extension'],'webp',\Voyager::image($featuredProduct->getThumbnail($featuredProduct->thumb, 'small')));
            $featuredProduct->setAttribute('thumbnail', $thumbnail);
        }
//        $featuredProducts = $featuredProducts->translate($locale,$fallbackLocale);

        return view('products.show',compact('product','productT','featuredProducts','locale','fallbackLocale'));
    }

    public function getCurrentProduct($slug)
    {
        $locale = session()->get('locale');
        $fallbackLocale = config('app.fallback_locale');
        $compare = app('compare');
        $product = Product::with('translations')->whereSlug($slug)->first();
        $product->setAttribute('chars',unserialize($product->getTranslatedAttribute('characteristics',$locale,$fallbackLocale)));
        $product->setAttribute('inCompare', ($compare->get($product->id) !== null));
        $product = $product->translate($locale,$fallbackLocale);
        return response()->json(['product'=>$product, 'locale'=>$locale,'fallbackLocale'=>$fallbackLocale]);
    }
}
