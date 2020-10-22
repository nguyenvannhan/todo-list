<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    public $singletons = [
        \App\Core\Repositories\Contracts\TaskInterface::class => \App\Core\Repositories\TaskRepository::class,
        \App\Core\Repositories\Contracts\UserInterface::class => \App\Core\Repositories\UserRepository::class,
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
