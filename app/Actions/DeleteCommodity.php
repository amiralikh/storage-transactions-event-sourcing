<?php

namespace App\Actions;

use App\Aggregates\GoodsAggregateRoot;
use Illuminate\Support\Str;

class DeleteCommodity extends Action
{
    public function run($uuid)
    {
        GoodsAggregateRoot::retrieve(Str::uuid())
            ->deleteGoods($uuid)
            ->persist();
    }
}
