<?php

namespace App\Providers;

use App\Http\Interfaces\Api\{ExternalApiInterface, MovieInterface,UserInterface};
use App\Http\Repositories\Api\{MovieApiRepository, UserRepository,MovieRepository};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(MovieInterface::class, MovieRepository::class);
        $this->app->bind(ExternalApiInterface::class,MovieApiRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
