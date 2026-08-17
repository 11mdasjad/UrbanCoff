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

        // Share cart data with all views
        View::composer('*', function ($view) {
            try {
                $cartService = app(CartService::class);
                $totals = $cartService->getTotals();
                $view->with([
                    'cartCount' => $totals['count'],
                    'cartDrawerItems' => $totals['items'],
                    'cartDrawerSubtotal' => $totals['subtotal'],
                    'cartDrawerShipping' => $totals['shipping'],
                    'cartDrawerTotal' => $totals['total'],
                    'cartDrawerFreeShipping' => $totals['free_shipping'],
                ]);
            } catch (\Exception $e) {
                $view->with([
                    'cartCount' => 0,
                    'cartDrawerItems' => collect(),
                    'cartDrawerSubtotal' => 0,
                    'cartDrawerShipping' => 0,
                    'cartDrawerTotal' => 0,
                    'cartDrawerFreeShipping' => false,
                ]);
            }
        });
    }
}
