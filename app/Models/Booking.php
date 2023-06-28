<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_time', 'seat_number', 'payment'
    ];

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

   


}
