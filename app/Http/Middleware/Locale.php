<?php

namespace App\Http\Middleware;

use Closure;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $current = session()->get('locale');

        if (in_array($current, config('app.locales'))) {
            $locale = $current;
        } else {
            $locale = config('app.locale');
            session()->put('locale', $locale);
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
