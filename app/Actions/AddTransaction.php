<?php

namespace App\Actions;

use App\Aggregates\TransactionAggregateRoot;
use App\Models\Goods;
use App\Models\Warehouse;
use Illuminate\Support\Str;

class AddTransaction extends Action
{
    public function run(int $quantity, string $warehouseUUID, string $commodityUUID): void
    {
        TransactionAggregateRoot::retrieve(Str::uuid())
            ->increaseItem($quantity,$warehouseUUID,$commodityUUID)
            ->persist();
    }
}
