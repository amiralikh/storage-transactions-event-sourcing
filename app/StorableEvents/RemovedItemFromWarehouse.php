<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class RemovedItemFromWarehouse extends ShouldBeStored
{
    public function __construct(
        public int $quantity,
        public string $warehouseUUID,
        public string $commodityUUID
    ){
        //
    }

}
