<?php

namespace App\Actions;

use App\Aggregates\TransactionAggregateRoot;
use App\Aggregates\WarehouseAggregateRoot;
use Illuminate\Support\Str;

class DecreaseTransaction extends Action
{
    public function run(int $quantity, string $warehouseUUID, string $commodityUUID): void
    {

        WarehouseAggregateRoot::retrieve($warehouseUUID)
            ->decreaseItem($quantity,$warehouseUUID,$commodityUUID)
            ->persist();
    }
}
