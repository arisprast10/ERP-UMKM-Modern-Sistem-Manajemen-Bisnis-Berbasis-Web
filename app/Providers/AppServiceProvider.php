<?php

namespace App\Providers;

use App\Models\StoreSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share store setting to ALL views globally
        View::composer('*', function ($view) {
            $setting = cache()->remember('store_setting', 60, function () {
                return StoreSetting::first() ?? new StoreSetting([
                    'store_name'    => 'Toko UMKM',
                    'store_address' => '',
                    'store_phone'   => '',
                ]);
            });
            $view->with('storeSetting', $setting);
        });
    }
}
