<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Transaction
 * 
 * @property string $type
 */
class Transaction extends Model
{
    protected $fillable = [
        'date', 'type', 'product_id', 'price', 'quantity',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $appends = ['total'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('date', 'desc')->orderBy('id', 'desc');
        });

        // static::saving(function ($item) {
        //     $item['total'] = $item['price'] * $item['quantity'];
        // });
    
        static::created(function ($item) {
            if ($item->type == 'in') {
                $item->stock()->create([
                    'product_id' => $item->product_id,
                    'purchase_price' => $item->price,
                    'stock' => $item->quantity,
                ]);
            } else {
                $qty = $item->quantity;
                $stocks = Stock::where('product_id', $item->product_id)->get();
                foreach ($stocks as $stock) {
                    if ($stock->stock > 0) {
                        $old_stock = $stock->stock;
                        $stock->update([
                            'stock' => $old_stock - min($old_stock, $qty),
                        ]);
                        $item->details()->create([
                            'stock_id' => $stock->id,
                            'quantity' => min($old_stock, $qty),
                        ]);
                        $qty -= min($old_stock, $qty);
                        if ($qty == 0) break;
                    }
                }
            }
        });
    }

    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stock()
    {
        if ($this->type == 'in') {
            return $this->hasOne(Stock::class);
        }
        return null;
    }

    public function details()
    {
        if ($this->type == 'out') {
            return $this->hasMany(TransactionDetail::class);
        }
        return null;
    }
}
