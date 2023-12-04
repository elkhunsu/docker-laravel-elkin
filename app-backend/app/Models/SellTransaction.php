<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'currency_id',
        'amount',
        'total_amount',
        'timestamp',
        'notification',
    ];

    protected $primaryKey = 'transaction_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
