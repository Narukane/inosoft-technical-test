<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SalesRepositoryInterface;
use App\Repositories\EloquentSalesRepository;

class SalesRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SalesRepositoryInterface::class, EloquentSalesRepository::class);
    }
}