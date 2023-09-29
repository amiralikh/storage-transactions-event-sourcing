<?php

namespace App\Projectors;

use App\Models\Warehouse;
use App\StorableEvents\WarehouseCreated;
use App\StorableEvents\WarehouseDeleted;
use App\StorableEvents\WarehouseUpdated;
use Illuminate\Support\Str;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class WarehouseProjector extends Projector
{
    public function onWarehouseCreated(WarehouseCreated $event): void
    {
        (new Warehouse())->writeable()->create([
            'uuid' => $event->warehouseUuid,
            'name' => $event->name
        ]);
    }

    public function onWarehouseUpdated(WarehouseUpdated $event): void
    {
        $warehouse = $this->findWarehouse($event->warehouseUuid);
        $warehouse->writeable()->update([
            'name' => $event->name
        ]);
    }

    public function onWarehouseDelete(WarehouseDeleted $event)
    {
        $warehouse = $this->findWarehouse($event->warehouseUuid);
        $warehouse->writeable()->delete();

    }

    private function findWarehouse(string $uuid): ?Warehouse
    {
        $warehouse = Warehouse::query()->where('uuid',$uuid)->firstOrFail();
        throw_if(!$warehouse, 'this warehouse does not exists!');
        return $warehouse;
    }
}
