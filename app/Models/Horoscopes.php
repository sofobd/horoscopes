<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horoscopes extends Model
{
    use HasFactory;
    protected $fillable = ['zodiac_sign_id','horoscope_score','day','month','year'];
}
