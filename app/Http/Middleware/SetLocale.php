<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->get('lang', session('app_locale', 'ar'));
        
        if (in_array($locale, ['en', 'ar'])) {
            session(['app_locale' => $locale]);
            app()->setLocale($locale);
            config(['app.locale' => $locale]);
        } else {
            $locale = 'ar';
            session(['app_locale' => $locale]);
            app()->setLocale($locale);
            config(['app.locale' => $locale]);
        }
        
        return $next($request);
    }
}
