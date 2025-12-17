<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','agency_id','type','amount','balance_after','reference','meta'
    ];

    protected $casts = [
        'amount' => 'float',
        'balance_after' => 'float',
        'meta' => 'array',
    ];
}
