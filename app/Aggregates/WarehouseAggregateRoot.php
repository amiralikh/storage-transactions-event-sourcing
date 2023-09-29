<?php

namespace App\Aggregates;

use App\Models\Goods;
use App\StorableEvents\AddedTransactionToWarehouse;
use App\StorableEvents\RemovedItemFromWarehouse;
use App\StorableEvents\WarehouseCreated;
use App\StorableEvents\WarehouseDeleted;
use App\StorableEvents\WarehouseUpdated;
use phpDocumentor\Reflection\Types\Collection;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class WarehouseAggregateRoot extends AggregateRoot
{
    protected bool $exists = false;

    protected array $commodities = [];

    public function createWarehouse(string $name): self
    {
        $this->recordThat(new WarehouseCreated($this->uuid(), $name));
        return $this;
    }

    public function updateWarehouse(string $uuid, string $name): self
    {
        throw_if(!$this->exists, new \Exception("event does not exist"));
        $this->recordThat(new WarehouseUpdated($uuid, $name));
        return $this;
    }

    public function deleteWarehouse(string $uuid): self
    {
        throw_if(!$this->exists, new \Exception("event does not exist"));
        $this->recordThat(new WarehouseDeleted($uuid));
        return $this;
    }

    public function applyWarehouseAdded(WarehouseCreated $event): void
    {
        $this->exists = true;
    }

    public function applyAddedTransaction(AddedTransactionToWarehouse $event)
    {
        if (!isset($this->commodities[$event->commodityUUID])) {
            $this->commodities[$event->commodityUUID] = 0;
        }

        $this->commodities[$event->commodityUUID] += $event->quantity;
    }

    public function increaseItem(int $quantity, string $commodityUUID
    ): self
    {
        if (!$this->exists) {
            throw new \InvalidArgumentException("Selected warehouse is invalid");
        }

        $this->recordThat(new AddedTransactionToWarehouse($quantity, $this->uuid(), $commodityUUID));
        return $this;
    }

    public function decreaseItem(
        int    $quantity,
        string $warehouseUUID,
        string $commodityUUID
    ): self
    {
        if (!$this->exists) {
            throw new \InvalidArgumentException("Selected warehouse is invalid");
        }

        if (isset($this->commodities[$commodityUUID]) && $this->commodities[$commodityUUID] < $quantity){
            throw new \InvalidArgumentException("quantity not enough");
        }

        $this->recordThat(new RemovedItemFromWarehouse($quantity, $warehouseUUID, $commodityUUID));
        return $this;
    }

}
