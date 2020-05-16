<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id', 'stock_id', 'quantity',
    ];

    protected $appends = ['total'];

    public $timestamps = false;

    public function getTotalAttribute()
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
