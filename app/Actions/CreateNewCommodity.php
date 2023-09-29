<?php

namespace App\Actions;

use App\Aggregates\GoodsAggregateRoot;
use Illuminate\Support\Str;

class CreateNewCommodity extends Action
{
    public function run($name)
    {
        GoodsAggregateRoot::retrieve(Str::uuid())
            ->createGoods($name)
            ->persist();
    }
}
