<?php

namespace App\Actions;

use App\Aggregates\WarehouseAggregateRoot;
use App\Models\Goods;
use Illuminate\Support\Str;

class UpdateCommodity extends Action
{
    public function run($uuid,$name)
    {
        Goods::query()->where('uuid',$uuid)->firstOrFail()->update(['name' => $name]);
    }
}
