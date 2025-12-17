<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','agency_id','type','flight_id','passengers','status',
        'amount','currency','payment_status','payment_reference','notes','meta'
    ];

    protected $casts = [
        'passengers' => 'array',
        'amount' => 'float',
        'meta' => 'array',
    ];
}
