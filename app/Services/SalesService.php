<?php

namespace App\Services;

use App\Repositories\VehicleRepositoryInterface;
use App\Repositories\SalesRepositoryInterface;
use App\Models\Car;
use App\Models\Motor;
use App\Models\Sales;

class SalesService
{
    private $salesRepository;
    private $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository, SalesRepositoryInterface $salesRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->salesRepository = $salesRepository;
    }

    // Start of Sales Functions
    public function createSales(array $data)
    {
        try {
            $itemTipe = $data['tipe'];
            $itemId = $data['item_id'];
            $jumlah = $data['jumlah'];
    
            // Get the selected vehicle item
            if ($itemTipe === 'Mobil') {
                $item = $this->vehicleRepository->getCarById($itemId);
            } else {
                $item = $this->vehicleRepository->getMotorById($itemId);
            }
    
            // Check if item exists
            if (!$item) {
                throw new \Exception('Selected item not found.');
            }
            
            // Check the stock availability
            if ($item->stok > 0) {
                if ($jumlah > $item->stok){
                    throw new \Exception('Insufficient stock. Available stock: ' . $item->stok);
                }
            } else {
                throw new \Exception('Out of stock');
            }

            // Calculate the total Price
            $totalHarga = $jumlah * $item->harga;
    
            // Decrease the stock of the selected vehicle item
            $this->vehicleRepository->decreaseStock($itemTipe, $itemId, $jumlah);
    
            // Create the sales record
            $itemObject = json_decode($item);
            $salesData = [
                'nama_customer' => $data['nama_customer'],
                'jumlah' => $jumlah,
                'total_harga' => $totalHarga,
                'item' => $itemObject,
            ];
    
            return $this->salesRepository->createSales($salesData);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return ['error' => $e->getMessage()];
        }
    }
    
    public function getAllSales()
    {
        return $this->salesRepository->getAllSales();
    }
    
    public function getSalesById(string $salesId)
    {
        return $this->salesRepository->getSalesById($salesId);
    }
    // End of Sales Functions
}