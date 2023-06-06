<?php

namespace App\Http\Controllers;

use App\Services\SalesService;
use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SalesController extends Controller
{
    private $salesService;
    private $vehicleService;

    public function __construct(SalesService $salesService, VehicleService $vehicleService)
    {
        $this->salesService = $salesService;
        $this->vehicleService = $vehicleService;
    }

    /**
     * Create a new sales record.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createSales(Request $request): JsonResponse
    {

        try {
            $request->validate([
                'nama_customer' => 'required|string',
                'jumlah' => 'required|numeric',
                'tipe' => 'required|in:Motor,Mobil',
                'item_id' => 'required|string',
            ]);

            $itemTipe = $request->input('tipe');
            $itemId = $request->input('item_id');
            $jumlah = $request->input('jumlah');

            // Get the selected vehicle item
            if ($itemTipe === 'Mobil') {
                $item = $this->vehicleService->getCarById($itemId);
            } else {
                $item = $this->vehicleService->getMotorById($itemId);
            }
            
            // Check the stock availability
            if ($item->stok > 0) {
                if ($jumlah > $item->stok) {
                    throw new \Exception('Insufficient stock. Available stock: ' . $item->stok);
                }
            } else {
                throw new \Exception('Out of stock');
            }

            $data = $request->only(['nama_customer', 'jumlah', 'tipe', 'tipe', 'item_id']);
            $sales = $this->salesService->createSales($data, $item);

            return response()->json(['data' => $sales], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Item not found'], 404);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            if ($e->getMessage() === 'Out of stock' || strpos($e->getMessage(), 'Insufficient stock.') === 0) {
                return response()->json(['error' => $e->getMessage()], 400);
            } else {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    /**
     * Get all Sales Report.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllSales(): JsonResponse
    {
        try {
            $sales = $this->salesService->getAllSales();

            return response()->json(['data' => $sales], 200);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get a specific sales by ID.
     *
     * @param  string  $salesId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesById(string $salesId): JsonResponse
    {
        try {
            $sales = $this->salesService->getSalesById($salesId);
            return response()->json(['data' => $sales], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'sales not found'], 404);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}