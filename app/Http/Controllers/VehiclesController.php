<?php

namespace App\Http\Controllers;

use App\Services\VehicleService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
                'stock' => 'required|numeric',
                'detail' => 'required|array',
                'detail.mesin' => 'required',
                'detail.kapasitas_penumpang' => 'required|numeric',
                'detail.tipe' => 'required',
            ]);

            $carData = $request->only(['tahun_keluaran', 'warna', 'harga', 'tipe', 'stock', 'detail']);
            $car = $this->vehicleService->createCar($carData);

            return response()->json(['car' => $car], 201);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
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
                'stock' => 'required|numeric',
                'detail' => 'required|array',
                'detail.mesin' => 'required',
                'detail.tipe_suspensi' => 'required',
                'detail.tipe_transmisi' => 'required',
            ]);

            $motorData = $request->only(['tahun_keluaran', 'warna', 'harga', 'tipe', 'stock', 'detail']);
            $motor = $this->vehicleService->createMotor($motorData);

            return response()->json(['motor' => $motor], 201);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}