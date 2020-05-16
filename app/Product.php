<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code', 'name', 'price',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        });
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function totalStock()
    {
        return $this->hasOne(Stock::class)
            ->selectRaw('product_id, sum(stock) as aggregate')
            ->groupBy('product_id');
    }

    public function getTotalStockAttribute()
    {
        if (!array_key_exists('totalStock', $this->relations)) {
            $this->load('totalStock');
        }

        $relation = $this->getRelation('totalStock');

        return $relation ? $relation->aggregate : 0;
    }
}
