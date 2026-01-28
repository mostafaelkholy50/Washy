<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('path.public', function () {
            return base_path(env('PUBLIC_PATH', 'public'));
        });
    }

    public function boot(): void
    {
        $locale = session('app_locale', 'ar');
        app()->setLocale($locale);
        config(['app.locale' => $locale]);

        View::composer('admin.*', function ($view) {
            $setting = Setting::first();
            $view->with('setting', $setting);
        });
    }
}
