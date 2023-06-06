<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\VehicleRepositoryInterface;
use App\Repositories\EloquentVehicleRepository;

class VehicleRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(VehicleRepositoryInterface::class, EloquentVehicleRepository::class);
    }
}