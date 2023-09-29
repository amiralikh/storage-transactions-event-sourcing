<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EventSourcing\Projections\Projection;

class Goods extends Projection
{
    use HasFactory;
    protected $fillable=['uuid','name'];

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class)
            ->using(WarehouseGoods::class)
            ->withPivot('quantity');
    }
}
