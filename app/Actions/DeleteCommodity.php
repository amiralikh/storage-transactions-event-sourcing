<?php

namespace App\Actions;

use App\Aggregates\WarehouseAggregateRoot;
use App\Models\Goods;
use Illuminate\Support\Str;

class DeleteCommodity extends Action
{
    public function run($uuid)
    {
        Goods::query()->where('uuid',$uuid)->first()->delete();
    }
}
