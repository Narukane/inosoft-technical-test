<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\Motor;
use Illuminate\Support\Collection;

class EloquentVehicleRepository implements VehicleRepositoryInterface
{
    // Start of Car Functions
    public function createCar(array $data): Car
    {
        return Car::create($data);
    }
    
    public function getAllCars(): Collection
    {
        return Car::all();
    }
    
    public function getCarById(string $carId): ?Car
    {
        return Car::findOrFail($carId);
    }
    
    public function updateCar(Car $car, array $carData): Car
    {
        $car->update($carData);
        return $car;
    }
    
    public function deleteCar(string $carId): void
    {
        Car::findOrFail($carId)->delete();
    }
    // End of Car Functions

    // Start of Motor Functions
    public function createMotor(array $data): Motor
    {
        return Motor::create($data);
    }
    
    public function getAllMotors(): Collection
    {
        return Motor::all();
    }
    
    public function getMotorById(string $motorId): ?Motor
    {
        return Motor::findOrFail($motorId);
    }
    
    public function updateMotor(Motor $motor, array $motorData): Motor
    {
        $motor->update($motorData);
        return $motor;
    }
    
    public function deleteMotor(string $motorId): void
    {
        Motor::findOrFail($motorId)->delete();
    }
    // End of Motor Functions
}