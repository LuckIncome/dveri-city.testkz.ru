<?php

namespace App\Http\Controllers;

use App\Post;
use App\Sale;

class SalesController extends Controller
{
    public function index()
    {
        $locale = session()->get('locale');
        $fallbackLocale = config('app.fallback_locale');
        $sales = Sale::with('translations')->where('status',Post::PUBLISHED)->paginate('5');
        $sales = $sales->translate($locale,$fallbackLocale);
        return view('sales.index', compact('sales'));
    }


    public function show($slug)
    {
        $locale = session()->get('locale');
        $fallbackLocale = config('app.fallback_locale');

        $sale = Sale::where('status',Post::PUBLISHED)->where('slug',$slug)->first();
        $sale = $sale->translate($locale,$fallbackLocale);
        return view('sales.show', compact('sale'));
    }
}
