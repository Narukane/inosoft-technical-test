<?php

namespace App\Http\Controllers;

use App\Services\SalesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SalesController extends Controller
{
    private $salesService;

    public function __construct(SalesService $salesService)
    {
        $this->salesService = $salesService;
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
            $data = $request->validate([
                'nama_customer' => 'required|string',
                'jumlah' => 'required|numeric',
                'tipe' => 'required|in:Motor,Mobil',
                'item_id' => 'required|string', // or 'motor_id' depending on the property name
            ]);

            $sales = $this->salesService->createSales($data);

            return response()->json(['data' => $sales], 201);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
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
