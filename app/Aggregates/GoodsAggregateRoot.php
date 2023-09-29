<?php

namespace App\Aggregates;

use App\Events\GoodsCreated;
use App\Events\GoodsDeleted;
use App\Events\GoodsUpdated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class GoodsAggregateRoot extends AggregateRoot
{
    public function createGoods(string $name): self
    {
        $this->recordThat(new GoodsCreated($this->uuid(), $name));
        return $this;
    }

    public function updateGoods(string $uuid, string $name): self
    {
        $this->recordThat(new GoodsUpdated($uuid, $name));
        return $this;
    }

    public function deleteGoods(string $uuid): self
    {
        $this->recordThat(new GoodsDeleted($uuid));
        return $this;
    }
}
