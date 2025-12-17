<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Governorate extends Model
{
    use HasFactory;

    protected $fillable = ['name_ar','name_en','capital_ar','capital_en','meta'];
    protected $casts = ['meta'=>'array'];
}
