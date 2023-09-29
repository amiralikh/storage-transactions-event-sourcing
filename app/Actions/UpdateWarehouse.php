<?php

namespace App\Actions;

use App\Aggregates\WarehouseAggregateRoot;
use Illuminate\Support\Str;

class UpdateWarehouse extends Action
{
    public function run(string $uuid, string $name)
    {
        WarehouseAggregateRoot::retrieve('fake-uuid')
            ->updateWarehouse($uuid, $name)
            ->persist();
    }
}
