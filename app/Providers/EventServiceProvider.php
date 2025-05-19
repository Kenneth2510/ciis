<?php

namespace App\Providers;

use App\Listeners\LogSuccessfullLogin;
use App\Listeners\LogSuccessfullLogout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $listener = [
        Login::class => [LogSuccessfullLogin::class],
        Logout::class => [LogSuccessfullLogout::class]
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
