<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\Motor;
use Illuminate\Support\Collection;

interface VehicleRepositoryInterface
{
    // Start of Car Functions
    public function createCar(array $data): Car;
    public function getAllCars(): Collection;
    public function getCarById(string $carId): ?Car;
    public function updateCar(Car $car,array $carData): Car;
    public function deleteCar(string $carId): void;
    // End of Car Functions
    

    // Start of Motor Functions
    public function createMotor(array $data): Motor;
    public function getAllMotors(): Collection;
    public function getMotorById(string $motorId): ?Motor;
    public function updateMotor(Motor $motor,array $motorData): Motor;
    public function deleteMotor(string $motorId): void;
    // End of Motor Functions
    
    // Start of Sales Functions
    public function decreaseStock(string $itemTipe,string $itemId,int $jumlah): bool;
}