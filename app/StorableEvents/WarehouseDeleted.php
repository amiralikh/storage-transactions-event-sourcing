<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class WarehouseDeleted extends ShouldBeStored
{
    public function __construct(
        public string $warehouseUuid,
    ) {
        //
    }

}
