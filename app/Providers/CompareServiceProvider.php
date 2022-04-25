<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Darryldecode\Cart\Cart;

class CompareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('compare', function($app)
        {
            $storage = $app['session'];
            $events = $app['events'];
            $instanceName = 'compare';
            $session_key = 'dvericitycompareinstance';
            return new Cart(
                $storage,
                $events,
                $instanceName,
                $session_key,
                config('shopping_cart')
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
