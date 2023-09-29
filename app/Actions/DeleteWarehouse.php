<?php

namespace App\Actions;

use App\Aggregates\WarehouseAggregateRoot;
use Illuminate\Support\Str;

class DeleteWarehouse extends Action
{
    public function run($uuid)
    {
        WarehouseAggregateRoot::retrieve(Str::uuid())
            ->deleteWarehouse($uuid)
            ->persist();
    }
}
