<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zodiac_signs extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
}