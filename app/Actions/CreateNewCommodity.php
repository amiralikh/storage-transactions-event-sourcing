<?php

namespace App\Actions;

use App\Aggregates\GoodsAggregateRoot;
use App\Aggregates\WarehouseAggregateRoot;
use App\Models\Goods;
use Illuminate\Support\Str;

class CreateNewCommodity extends Action
{
    public function run($name)
    {
        Goods::query()->create([
            'uuid' => Str::uuid(),
            'name' => $name
        ]);
    }
}
