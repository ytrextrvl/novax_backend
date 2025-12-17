<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','type','commission_rate','wallet_balance','meta',
    ];

    protected $casts = [
        'commission_rate' => 'float',
        'wallet_balance' => 'float',
        'meta' => 'array',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
