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
    public function createSales(array $data, object $item)
    {
        // Get Data assign into new variables
        $itemTipe = $data['tipe'];
        $itemId = $data['item_id'];
        $jumlah = $data['jumlah'];

        // Calculate the total Price
        $totalHarga = $jumlah * $item->harga;

        // Decrease the stock of the selected vehicle item
        $this->vehicleRepository->decreaseStock($itemTipe, $itemId, $jumlah);

        // Create the sales record
        // Make $item into object and filter several values
        $itemObject = json_decode($item);
        $selectedProperties = [
            'tahun_keluaran',
            'warna',
            'harga',
            'detail',
        ];
        $filteredObject = (object) array_intersect_key((array) $itemObject, array_flip($selectedProperties));
        $salesData = [
            'nama_customer' => $data['nama_customer'],
            'jumlah' => $jumlah,
            'total_harga' => $totalHarga,
            'jenis_kendaraan' => $itemTipe,
            'item' => $filteredObject,
        ];

        return $this->salesRepository->createSales($salesData);
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