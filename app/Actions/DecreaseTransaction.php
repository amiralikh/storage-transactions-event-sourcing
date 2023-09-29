<?php

namespace App\Actions;

use App\Aggregates\TransactionAggregateRoot;
use Illuminate\Support\Str;

class DecreaseTransaction extends Action
{
    public function run(int $quantity, string $warehouseUUID, string $commodityUUID): void
    {
        TransactionAggregateRoot::retrieve(Str::uuid())
            ->decreaseItem($quantity,$warehouseUUID,$commodityUUID)
            ->persist();
    }
}
