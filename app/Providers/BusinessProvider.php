<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BusinessProvider extends ServiceProvider
{
    public $singletons = [
        \App\Core\Businesses\Contracts\TaskInterface::class => \App\Core\Businesses\TaskBusiness::class,
        \App\Core\Businesses\Contracts\UserInterface::class => \App\Core\Businesses\UserBusiness::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
