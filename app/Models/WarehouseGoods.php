<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EventSourcing\Projections\Projection;

class WarehouseGoods extends Projection
{
    use HasFactory;
    protected $guarded = [];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_uuid');
    }

    public function commodity(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Goods::class, 'commodity_uuid');
    }
}
