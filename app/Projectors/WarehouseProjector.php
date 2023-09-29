<?php

namespace App\Projectors;

use App\Events\WarehouseCreated;
use App\Events\WarehouseDeleted;
use App\Events\WarehouseUpdated;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class WarehouseProjector extends Projector
{
    public function onGoodsCreated(WarehouseCreated $event): void
    {
        (new Warehouse())->writeable()->create([
            'uuid' => Str::uuid(),
            'name' => $event->name
        ]);
    }

    public function onGoodsUpdated(WarehouseUpdated $event): void
    {
        $warehouse = $this->findWarehouse($event->goodsUuid);
        $warehouse->writeable()->update([
            'name' => $event->name
        ]);
    }

    public function onGoodsDelete(WarehouseDeleted $event)
    {
        $warehouse = $this->findWarehouse($event->goodsUuid);
        $warehouse->writeable()->delete();

    }

    private function findWarehouse(string $uuid): ?Warehouse
    {
        $warehouse = Warehouse::query()->where('uuid',$uuid)->first();
        throw_if(!$warehouse, 'this warehouse does not exists!');
        return $warehouse;
    }
}
