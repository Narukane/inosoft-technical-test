<?php

namespace App\Repositories;

use App\Models\Sales;
use Illuminate\Support\Collection;

class EloquentSalesRepository implements SalesRepositoryInterface
{
    // Start of Sales Functions
    public function createSales(array $data): Sales
    {
        return Sales::create($data);
    }
    
    public function getAllSales(): Collection
    {
        return Sales::all();
    }
    
    public function getSalesById(string $salesId): ?Sales
    {
        return Sales::findOrFail($salesId);
    }
    // End of Sales Functions
}