<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ApiAuthService;

class ApiAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
         $this->app->singleton(ApiAuthService::class, function ($app) {
            return new ApiAuthService(config('services.api.base_url'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
