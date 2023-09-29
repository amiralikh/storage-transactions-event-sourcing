<?php

namespace App\Projectors;

use App\Events\AddedTransactionToWarehouse;
use App\Events\RemovedItemFromWarehouse;
use App\Models\WarehouseGoods;
use Illuminate\Support\Facades\DB;
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

        if ($item){
            $item->quantity += $event->quantity;
            $item->writeable()->save();
        } else {
            WarehouseGoods::query()->writeable()->create(
                [
                    'warehouse_uuid' => $event->warehouseUUID,
                    'commodity_uuid' => $event->commodityUUID,
                    'quantity' => DB::raw('quantity + ' . $event->quantity),
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
}
