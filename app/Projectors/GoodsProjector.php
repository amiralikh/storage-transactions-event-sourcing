<?php

namespace App\Projectors;

use App\Events\GoodsCreated;
use App\Events\GoodsDeleted;
use App\Events\GoodsUpdated;
use App\Models\Goods;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class GoodsProjector extends Projector
{
    public function onGoodsCreated(GoodsCreated $event): void
    {
        (new Goods)->writeable()->create([
            'uuid' => $event->goodsUuid,
            'name' => $event->name
        ]);
    }

    public function onGoodsUpdated(GoodsUpdated $event)
    {
        $commodity = $this->findCommodity($event->goodsUuid);
        $commodity->writeable()->update([
            'name' => $event->name
        ]);
    }

    public function onGoodsDelete(GoodsDeleted $event)
    {
        $commodity = $this->findCommodity($event->goodsUuid);
        $commodity->writeable()->delete();

    }

    private function findCommodity(string $uuid): ?Goods
    {
        $commodity = Goods::query()->where('uuid',$uuid)->first();
        throw_if(!$commodity, 'this commodity does not exists!');
        return $commodity;
    }
}
