<?php

namespace App\Projectors;

use App\Models\Warehouse;
use App\Models\WarehouseGoods;
use App\StorableEvents\AddedTransactionToWarehouse;
use App\StorableEvents\RemovedItemFromWarehouse;
use Illuminate\Support\Str;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class TransactionProjector extends Projector
{
    public function onIncreaseItem(AddedTransactionToWarehouse $event): void
    {
        $item = WarehouseGoods::query()->where([
            'warehouse_uuid' => $event->warehouseUUID,
            'commodity_uuid' => $event->commodityUUID,
        ])->first();
        if ($item) {
            $item->quantity += $event->quantity;
            $item->writeable()->save();
        } else {
            (new WarehouseGoods)->writeable()->create(
                [
                    'warehouse_uuid' => $event->warehouseUUID,
                    'commodity_uuid' => $event->commodityUUID,
                    'quantity' => $event->quantity,
                    'uuid' => Str::uuid()
                ]
            );
        }


    }

    public function onDecreaseItem(RemovedItemFromWarehouse $event): void
    {
        WarehouseGoods::query()
            ->where([
                'warehouse_uuid' => $event->warehouseUUID,
                'commodity_uuid' => $event->commodityUUID,
            ])
            ->where('quantity', '>=', $event->quantity)
            ->decrement('quantity', $event->quantity);
    }

    public function resetState(): void
    {
        WarehouseGoods::query()->delete();
    }
}
