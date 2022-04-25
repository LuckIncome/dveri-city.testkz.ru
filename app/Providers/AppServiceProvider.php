<?php

namespace App\Providers;

use App\Seopage;
use App\Translation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Http\Controllers\ContentTypes\Image;
use TCG\Voyager\Http\Controllers\ContentTypes\MultipleImage;
use TCG\Voyager\Http\Controllers\Controller;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use TCG\Voyager\Http\Controllers\VoyagerController;
use TCG\Voyager\Http\Controllers\VoyagerSettingsController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Voyager::useModel('Translation', Translation::class);
        $this->app->bind(VoyagerBaseController::class, \App\Http\Controllers\Voyager\VoyagerBaseController::class);
        $this->app->bind(VoyagerController::class, \App\Http\Controllers\Voyager\VoyagerController::class);
        $this->app->bind(Controller::class, \App\Http\Controllers\Voyager\Controller::class);
        $this->app->bind(VoyagerSettingsController::class, \App\Http\Controllers\Voyager\VoyagerSettingsController::class);
        $this->app->bind(Image::class, \App\Http\Controllers\Voyager\ContentTypes\Image::class);
        $this->app->bind(MultipleImage::class, \App\Http\Controllers\Voyager\ContentTypes\MultipleImage::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer(['*'], function ($view)
        {
            $seo_page = Seopage::where('slug',\Request::url())->cacheFor(2592000)->cacheTags(['seo_page','seo','seopage']);
            if ($seo_page->exists()){
                $seoTitle = $seo_page->first()->meta_title ? $seo_page->first()->getTranslatedAttribute('meta_title',session()->get('locale'),config('app.fallback_locale')) : '';
                $keywords = $seo_page->first()->meta_keywords ? $seo_page->first()->getTranslatedAttribute('meta_keywords',session()->get('locale'),config('app.fallback_locale')) : '';
                $description = $seo_page->first()->meta_description ? $seo_page->first()->getTranslatedAttribute('meta_description',session()->get('locale'),config('app.fallback_locale')) : '';
            }else {
                $seoTitle = '';
                $keywords = '';
                $description = '';
            }
            $view->with('locale',session()->get('locale'));
            $view->with('fallbackLocale',config('app.fallback_locale'));
            $view->with('seoTitle', $seoTitle);
            $view->with('keywords', $keywords);
            $view->with('description', $description);
        });
    }
}
