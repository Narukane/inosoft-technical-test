<?php

namespace App\Services;

use App\Repositories\VehicleRepositoryInterface;

class VehicleService
{
    private $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function createCar(array $data)
    {
        return $this->vehicleRepository->createCar($data);
    }

    public function createMotor(array $data)
    {
        return $this->vehicleRepository->createMotor($data);
    }
}