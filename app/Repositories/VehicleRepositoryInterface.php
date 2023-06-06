<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\Motor;

interface VehicleRepositoryInterface
{
    public function createCar(array $data): Car;

    public function createMotor(array $data): Motor;
}