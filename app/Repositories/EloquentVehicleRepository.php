<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\Motor;

class EloquentVehicleRepository implements VehicleRepositoryInterface
{
    public function createCar(array $data): Car
    {
        return Car::create($data);
    }

    public function createMotor(array $data): Motor
    {
        return Motor::create($data);
    }
}