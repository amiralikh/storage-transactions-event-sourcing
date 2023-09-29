<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
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
