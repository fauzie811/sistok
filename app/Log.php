<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'user_id', 'action', 'details',
    ];

    protected $casts = [
        'details' => 'array',
    ];

    protected static function boot()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        });
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
