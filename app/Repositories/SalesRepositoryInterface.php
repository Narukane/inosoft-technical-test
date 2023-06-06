<?php

namespace App\Repositories;

use App\Models\Sales;
use Illuminate\Support\Collection;

interface SalesRepositoryInterface
{
    // Start of Sales Functions
    public function createSales(array $data): Sales;
    public function getAllSales(): Collection;
    public function getSalesById(string $salesId): ?Sales;
    // End of Sales Functions
}