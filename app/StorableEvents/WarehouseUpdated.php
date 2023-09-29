<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class WarehouseUpdated extends ShouldBeStored
{

    public function __construct(
        public string $warehouseUuid,
        public string $name
    ) {
        //
    }
}
