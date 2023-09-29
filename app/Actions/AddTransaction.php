<?php

namespace App\Actions;

use App\Aggregates\WarehouseAggregateRoot;
use App\Models\Goods;
use App\Models\Warehouse;
use Illuminate\Support\Str;

class AddTransaction extends Action
{
    public function run(int $quantity, string $warehouseUUID, string $commodityUUID): void
    {
        $exists = Goods::query()->where('uuid',$commodityUUID)->exists();
        throw_unless($exists ,new \Exception("invalid goods"));
        WarehouseAggregateRoot::retrieve($warehouseUUID)
            ->increaseItem($quantity,$commodityUUID)
            ->persist();
    }
}
