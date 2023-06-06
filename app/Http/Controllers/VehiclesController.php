<?php

namespace App\Http\Controllers;

use App\Services\VehicleService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @property \App\Services\VehicleService $vehicleService
 */
class VehiclesController extends Controller
{
    private $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    /**
     * Create a new car.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCar(Request $request): JsonResponse
    {
        try {
            $request->merge(['tipe' => 'Mobil']);

            $request->validate([
                'tahun_keluaran' => 'required||digits:4|integer|min:1900|max:' . (date('Y') + 1),
                'warna' => 'required',
                'harga' => 'required|numeric',
                'stok' => 'required|numeric',
                'detail' => 'required|array',
                'detail.mesin' => 'required',
                'detail.kapasitas_penumpang' => 'required|numeric',
                'detail.tipe' => 'required',
            ]);

            $carData = $request->only(['tahun_keluaran', 'warna', 'harga', 'tipe', 'stok', 'detail']);
            $car = $this->vehicleService->createCar($carData);

            return response()->json(['data' => $car], 201);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
     /**
     * Get all cars.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllCars(): JsonResponse
    {
        try {
            $cars = $this->vehicleService->getAllCars();

            return response()->json(['data' => $cars], 200);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Get a specific car by ID.
     *
     * @param  string  $carId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCarById(string $carId): JsonResponse
    {
        try {
            $car = $this->vehicleService->getCarById($carId);
            return response()->json(['data' => $car], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Car not found'], 404);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Update a car by ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $carId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCar(Request $request, string $carId): JsonResponse
    {
        try {
            $car = $this->vehicleService->getCarById($carId);

            if (!$car) {
                return response()->json(['error' => 'Car not found'], 404);
            }

            $request->validate([
                'tahun_keluaran' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
                'warna' => 'required',
                'harga' => 'required|numeric',
                'stok' => 'required|numeric',
                'detail' => 'required|array',
                'detail.mesin' => 'required',
                'detail.kapasitas_penumpang' => 'required|numeric',
                'detail.tipe' => 'required',
            ]);

            $carData = $request->only(['tahun_keluaran', 'warna', 'harga', 'tipe', 'stok', 'detail']);
            $updatedCar = $this->vehicleService->updateCar($car, $carData);

            return response()->json(['data' => $updatedCar], 200);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Delete car by ID.
     *
     * @param  string  $carId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCar(string $carId): JsonResponse
    {
        try {
            $this->vehicleService->deleteCar($carId);
    
            return response()->json(['message' => 'Car deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Car not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Create a new motor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createMotor(Request $request): JsonResponse
    {
        try {
            $request->merge(['tipe' => 'Motor']);

            $request->validate([
                'tahun_keluaran' => 'required||digits:4|integer|min:1900|max:' . (date('Y') + 1),
                'warna' => 'required',
                'harga' => 'required|numeric',
                'stok' => 'required|numeric',
                'detail' => 'required|array',
                'detail.mesin' => 'required',
                'detail.tipe_suspensi' => 'required',
                'detail.tipe_transmisi' => 'required',
            ]);

            $motorData = $request->only(['tahun_keluaran', 'warna', 'harga', 'tipe', 'stok', 'detail']);
            $motor = $this->vehicleService->createMotor($motorData);

            return response()->json(['data' => $motor], 201);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
     /**
     * Get all Motor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllMotors(): JsonResponse
    {
        try {
            $motors = $this->vehicleService->getAllMotors();

            return response()->json(['data' => $motors], 200);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Get a specific motor by ID.
     *
     * @param  string  $motorId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMotorById(string $motorId): JsonResponse
    {
        try {
            $motor = $this->vehicleService->getMotorById($motorId);
            return response()->json(['data' => $motor], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Motor not found'], 404);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Update a motor by ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $motor
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMotor(Request $request, string $motorId): JsonResponse
    {
        try {
            $motor = $this->vehicleService->getMotorById($motorId);

            $request->validate([
                'tahun_keluaran' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
                'warna' => 'required',
                'harga' => 'required|numeric',
                'stok' => 'required|numeric',
                'detail' => 'required|array',
                'detail.mesin' => 'required',
                'detail.tipe_suspensi' => 'required',
                'detail.tipe_transmisi' => 'required',
            ]);

            $motorData = $request->only(['tahun_keluaran', 'warna', 'harga', 'tipe', 'stok', 'detail']);
            $updatedMotor = $this->vehicleService->updateMotor($motor, $motorData);

            return response()->json(['data' => $updatedMotor], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Motor not found'], 404);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Delete motor by ID.
     *
     * @param  string  $motorId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMotor(string $motorId): JsonResponse
    {
        try {
            $this->vehicleService->deleteMotor($motorId);
    
            return response()->json(['message' => 'Motor deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Motor not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}