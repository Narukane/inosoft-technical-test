<?php

namespace App\Services;

use App\Repositories\VehicleRepositoryInterface;
use App\Models\Car;
use App\Models\Motor;

class VehicleService
{
    private $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    // Start of Car Functions
    public function createCar(array $data)
    {
        return $this->vehicleRepository->createCar($data);
    }
    
    public function getAllCars()
    {
        return $this->vehicleRepository->getAllCars();
    }
    
    public function getCarById(string $carId)
    {
        return $this->vehicleRepository->getCarById($carId);
    }
    
    public function updateCar(Car $car,array $carData)
    {
        return $this->vehicleRepository->updateCar($car,$carData);
    }
    
    public function deleteCar(string $carId)
    {
        return $this->vehicleRepository->deleteCar($carId);
    }
    // End of Car Functions
    
    // Start of Motor Functions
    public function createMotor(array $data)
    {
        return $this->vehicleRepository->createMotor($data);
    }
    
    public function getAllMotors()
    {
        return $this->vehicleRepository->getAllMotors();
    }
    
    public function getMotorById(string $carId)
    {
        return $this->vehicleRepository->getMotorById($carId);
    }
    
    public function updateMotor(Motor $motor,array $motorData)
    {
        return $this->vehicleRepository->updateMotor($motor,$motorData);
    }
    
    public function deleteMotor(string $motorId)
    {
        return $this->vehicleRepository->deleteMotor($motorId);
    }
    // End of Motor Functions
}