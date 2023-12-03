<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'currency_id',
        'exchange_rate_used',
        'type_transaction',
        'timestamp',
    ];

    protected $primaryKey = 'log_id';

    public function transaction()
    {
        return $this->belongsTo(BuyTransaction::class, 'transaction_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
