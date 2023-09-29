<?php

namespace App\Actions;

use App\Aggregates\GoodsAggregateRoot;
use Illuminate\Support\Str;

class UpdateCommodity extends Action
{
    public function run($uuid,$name)
    {
        GoodsAggregateRoot::retrieve(Str::uuid())
            ->updateGoods($uuid,$name)
            ->persist();
    }
}
