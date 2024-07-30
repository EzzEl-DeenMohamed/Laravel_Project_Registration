<?php

namespace App\Providers;

use App\repository\Contracts\RegistrationRepositoryInterface;
use App\repository\RegistrationRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RegistrationRepositoryInterface::class, RegistrationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
