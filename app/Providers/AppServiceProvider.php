<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SsoAuthServices;
use App\Repository\SsoAuthRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SsoAuthRepository::class, SsoAuthServices::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
