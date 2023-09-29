<?php

namespace App\Aggregates;

use App\Events\WarehouseCreated;
use App\Events\WarehouseDeleted;
use App\Events\WarehouseUpdated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class WarehouseAggregateRoot extends AggregateRoot
{
    public function createWarehouse(string $name): self
    {
        $this->recordThat(new WarehouseCreated($this->uuid(), $name));
        return $this;
    }

    public function updateWarehouse(string $uuid, string $name): self
    {
        $this->recordThat(new WarehouseUpdated($uuid, $name));
        return $this;
    }

    public function deleteWarehouse(string $uuid): self
    {
        $this->recordThat(new WarehouseDeleted($uuid));
        return $this;
    }
}
