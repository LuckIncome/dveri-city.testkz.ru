<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Darryldecode\Cart\Cart;

class CompareController extends Controller
{
    public function addToCompare($productId)
    {
        $product = Product::with('options')->whereId($productId)->first();
        if ($product->sale_price) {
            $price = $product->sale_price;
        } else {
            $price = $product->regular_price;
        }
        if (app('compare')->get($productId) == null) {
            app('compare')->add(['id' => $product->id, 'name' => $product->slug, 'quantity' => 1, 'price' => $price,
                'attributes' => [
                    'thumbnail' => $product->thumb,
                    'name' => $product->name,
                    'stock_count' => $product->stock_count,
                    'is_new' => $product->is_new,
                    'chars' => unserialize($product->characteristics),
                    'options' => $product->options,
                    'regular_price' => ($product->sale_price) ? $product->regular_price : false,
                    'link' => '/catalog/' . $product->category->slug . '/' . $product->slug
                ]]);
        }

        $products = app('compare')->getContent();


        return response()->json(['products' => $products]);
    }

    public function getCompareItems()
    {
        return response()->json(['itemsCount' => app('compare')->getTotalQuantity()]);
    }

    public function getCompareContent()
    {
        $compare = app('compare');
        $products = $compare->getContent();
        $itemsCount = $compare->getTotalQuantity();
        foreach ($products as $product) {
            $product->attributes['image_link'] = \Voyager::image($product->attributes['thumbnail']);
        }
        return response()->json(['products' => $products, 'itemsCount' => $itemsCount]);
    }

    public function index()
    {
        $products = app('compare')->getContent();
        $itemsCount = app('compare')->getTotalQuantity();

        return view('products.compare', compact('products', 'itemsCount'));
    }

    public function destroy()
    {
        app('compare')->clear();
        return response()->json(['products' => null, 'itemsCount' => 0]);
    }

    public function removeFromCompare(Request $request)
    {
        $compare = app('compare');
        $compare->remove($request->get('itemId'));

        $products = $compare->getContent();
        $itemsCount = $compare->getTotalQuantity();
        foreach ($products as $product) {
            $product->attributes['image_link'] = \Voyager::image($product->attributes['thumbnail']);
        }
        return response()->json(['products' => $products, 'itemsCount' => $itemsCount]);
    }


}
