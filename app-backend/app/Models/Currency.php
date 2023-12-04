<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $primaryKey = 'currency_id';

    protected $fillable = [
        'currency_code',
        'currency_name',
        'exchange_rate',
    ];
}
