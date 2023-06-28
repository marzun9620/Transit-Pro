<?php

// app/Models/Seat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'seat_number',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}

