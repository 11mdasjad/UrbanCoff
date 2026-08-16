<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CartService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production' || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) || env('VERCEL') || env('APP_ENV') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Share cart count with all views
        View::composer('*', function ($view) {
            try {
                $cartService = app(CartService::class);
                $view->with('cartCount', $cartService->count());
            } catch (\Exception $e) {
                $view->with('cartCount', 0);
            }
        });
    }
}
