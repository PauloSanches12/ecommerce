<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repositories
        $this->app->bind(
            \App\Interfaces\RepositoriesInterface\ProductRepositoryInterface::class,
            \App\Repositories\ProductRepository::class
        );

        $this->app->bind(
            \App\Interfaces\RepositoriesInterface\CategoryRepositoryInterface::class,
            \App\Repositories\CategoryRepository::class
        );

        $this->app->bind(
            \App\Interfaces\RepositoriesInterface\AuthRepositoryInterface::class,
            \App\Repositories\AuthRepository::class
        );

        // Services
        $this->app->bind(
            \App\Interfaces\ServicesInterface\ProductServiceInterface::class,
            \App\Services\ProductService::class
        );

        $this->app->bind(
            \App\Interfaces\ServicesInterface\CategoryServiceInterface::class,
            \App\Services\CategoryService::class
        );

        $this->app->bind(
            \App\Interfaces\ServicesInterface\AuthServiceInterface::class,
            \App\Services\AuthService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
