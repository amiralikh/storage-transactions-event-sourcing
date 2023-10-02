<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EventSourcing\Projections\Projection;

class Warehouse extends Projection
{
    use HasFactory;
    protected $fillable=['uuid','name'];

    public function commodities()
    {
        return $this->belongsToMany(Goods::class)
            ->using(WarehouseGoods::class)
            ->withPivot('quantity');
    }

}
