<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\AuditObserver;
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
        $models = [
            User::class,
            // Role::class,
        ];


        foreach ($models as $model)
        {
            $model::observe(AuditObserver::class);
        }
    }
}
