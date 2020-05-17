<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id', 'stock_id', 'quantity',
    ];

    protected $appends = ['total', 'total_purchase'];

    public $timestamps = false;

    public function getTotalAttribute()
    {
        return $this->stock->product->price * $this->quantity;
    }

    public function getTotalPurchaseAttribute()
    {
        return $this->stock->purchase_price * $this->quantity;
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
