<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id','travel_id','bus_id','travel_date'
    ];
}

