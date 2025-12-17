<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'airline_code','from_city_id','to_city_id','depart_at','arrive_at',
        'cabin_class','base_price','currency','seats','status','meta'
    ];

    protected $casts = [
        'depart_at' => 'datetime',
        'arrive_at' => 'datetime',
        'base_price' => 'float',
        'meta' => 'array',
    ];
}
