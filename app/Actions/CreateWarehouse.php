<?php

namespace App\Actions;

use App\Aggregates\WarehouseAggregateRoot;
use Illuminate\Support\Str;

class CreateWarehouse extends Action
{
    public function run($name)
    {
        WarehouseAggregateRoot::retrieve(Str::uuid())
            ->createWarehouse($name)
            ->persist();
    }
}
