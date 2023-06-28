<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'bus_id', 'travel_id', 'staff_id','seat_cost','travel_date','status'
    ];
}
