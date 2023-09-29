<?php

namespace App\Aggregates;

use App\Events\AddedTransactionToWarehouse;
use App\Events\RemovedItemFromWarehouse;
use App\Models\Goods;
use App\Models\Warehouse;
use App\Models\WarehouseGoods;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class TransactionAggregateRoot extends AggregateRoot
{
    public function increaseItem(
        int    $quantity,
        string $warehouseUUID,
        string $commodityUUID
    ): self
    {
        if (!$this->findWarehouse($warehouseUUID)) {
            throw new \InvalidArgumentException("Selected warehouse is invalid");
        }

        if (!$this->findCommodity($commodityUUID)) {
            throw new \InvalidArgumentException("Selected commodity is invalid");
        }

        $this->recordThat(new AddedTransactionToWarehouse($quantity, $warehouseUUID, $commodityUUID));
        return $this;
    }

    public function decreaseItem(
        int    $quantity,
        string $warehouseUUID,
        string $commodityUUID
    ): self
    {
        if (!$this->findWarehouse($warehouseUUID)) {
            throw new \InvalidArgumentException("Selected warehouse is invalid");
        }

        if (!$this->findCommodity($commodityUUID)) {
            throw new \InvalidArgumentException("Selected commodity is invalid");
        }
        if (!$this->decreaseAllowance($quantity, $warehouseUUID, $commodityUUID)) {
            throw new \InvalidArgumentException("Not enough item(s) in the warehouse");
        }

        $this->recordThat(new RemovedItemFromWarehouse($quantity, $warehouseUUID, $commodityUUID));
        return $this;
    }

    private function findWarehouse(string $uuid): bool
    {
        return Warehouse::query()->where('uuid', $uuid)->exists();
    }

    private function findCommodity(string $uuid): bool
    {
        return Goods::query()->where('uuid', $uuid)->exists();
    }

    private function decreaseAllowance(int $quantity, string $warehouseUUID, string $commodityUUID): bool
    {
        return WarehouseGoods::query()->where([
            'warehouse_uuid' => $warehouseUUID,
            'commodity_uuid' => $commodityUUID,
        ])
            ->where('quantity', '>=', $quantity)->exists();
    }
}
